<?php

//namespace App\Models;

class TicketModel extends Model {

    public function create() {
        // M: Get the departments and the pass to the view;
        $this->query("SELECT * FROM departments");
        $departments = $this->resultSet();
        // M: Check if the ticket was subbmited
        // M: Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $errors = [];
        if ($post['submit']) {
            if (empty($post['subject'])) {
                array_push($errors, 'Subject field is empty');
            }

            if (empty($post['email'])) {
                array_push($errors, 'Email field is empty');
            }

            if (!empty($post['Message'])) {
                array_push($errors, 'Message field is empty');
            }

            if (!empty($errors)) {
                Messages::setMsg(implode('.<br>', $errors) . '.', 'error');
            } else {
                
                // M: Generate the unique reference field having the format xx-yyyy;
                // M: First, we take all the reference fields from the ticket table;
                $this->query('SELECT reference FROM ticket');
                $references = $this->resultSet();
                $referenceField = Utilities::generateReference($references);
                
                // M: Insert the ticket;
                $this->query('INSERT INTO ticket (id_department, subject, email, reference, status, date) VALUES (:id_department, :subject, :email, :reference, :status, :date)');
                $this->bind(':id_department', $post['department']);
                $this->bind(':subject', $post['subject']);
                $this->bind(':email', $post['email']);
                $this->bind(':status', 1);
                $this->bind(':reference', $referenceField);
                $this->bind(':date', date("Y-m-d H:i:s"));
                $this->execute();
                $ticketInsert = $this->lastInsertId();
                
                // M: Insert the message;
                $this->query('INSERT INTO replies (ticket_reference, message, iAuthor, date) VALUES (:ticket_reference, :message, :iAuthor, :date)');
                $this->bind(':ticket_reference', $referenceField);
                $this->bind(':message', $post['message']);
                $this->bind(':iAuthor', 1);
                $this->bind(':date', date("Y-m-d H:i:s"));
                $this->execute();
                $replyInsert = $this->lastInsertId();
                
                // M: Verify
                if ($ticketInsert && $replyInsert) {
                    // M: Success message and redirect;
                    // M: Also remember how we reached that view ticket page;
                    $_SESSION['iAuthor'] = 1;
                    //Messages::setMsg($text, $type)
                    header('Location: ' . ROOT_URL);
                } else {
                    // M: Fail message and retry;
                    Messages::setMsg('Ups. We couldn\'t submit your ticket. Please try again.', 'error');
                }
            }
        }
        return $departments;
    }
    
    public function viewTickets() {
        // M: Store the info that we accesed the admin page;
        $_SESSION['iAuthor'] = 0;
        
        // M: Get all departments;
        $this->query("SELECT * FROM departments");
        $departments = $this->resultSet();
        array_unshift($departments, ['id' => '-1', 'name' => 'All']);
        
        $statuses = [
            0 => [
                'value' => -1,
                'name' => 'All'
            ],
            1 => [
                'value' => 0,
                'name' => 'Closed',
            ],
            2 => [
                'value' => 1,
                'name' => 'Open'
            ]
        ];
        
        // M: Empty array of filters;
        $filters= [];
        $tickets = [];
        
        // M: Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['filter'] == 'submit') {
            Messages::setMsg('Filtering complete', 'success');
            $query = "SELECT * FROM ticket WHERE 1";
            
            // M: Subject filter;
            if (!empty($post['subject'])) {
                $subject = $post['subject'];
                $query .= " AND subject LIKE '%$subject%'";
            }
            
            // M: Email filter;
            if (!empty($post['email'])) {
                $email = $post['email'];
                $query .= " AND email LIKE '%$email%'";
            }
            
            // M: Department title;
            if ($post['department'] != -1) {
                $idDepartment = $post['department'];
                $query .= " AND id_department = $idDepartment";
            } 
            
            // M: Status filter;
            if ($post['status'] != -1) {
                $status = $post['status'];
                $query .= " AND status = $status";
            }
            
            $orderValue = $post['date'];
            $order = $orderValue ? 'DESC' : 'ASC';
            $query .= " ORDER BY date $order";

            $this->query($query);
            $tickets = $this->resultSet();
            $filters = $post;
        } else {
            // M: Get all the tickets;
            $this->query('SELECT * FROM ticket');
            $tickets = $this->resultSet();
            $filters = [];
            if ($post['filter'] == 'reset') {
                Messages::setMsg('Filters are reseted.', 'success');
            }
        }
        
        return [
            'departments' => $departments,
            'tickets' => $tickets,
            'filters' => $filters,
            'statuses' => $statuses
        ];
    }
    
    public function view() {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        return $get;
    }
    
    public function delete() {
        // M: Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['id']) {
            // M: Check if the ticket with the given id exists;
            $this->query('SELECT * FROM ticket WHERE id = :id');
            $this->bind(':id', $post['id']);
            if ($ticket = $this->single()) {
                // M: If so, we delete the ticket;
                $this->query('DELETE FROM ticket WHERE id = :id');
                $this->bind(':id', $post['id']);
                $this->execute();
                Messages::setMsg("Ticket deleted with success.", 'success');
                return true;
            }
        } else {
            header('Location: ' . ROOT_URL . 'ticket/viewtickets');
            Messages::setMsg('Illegal try to access the page.', 'error');
        }
    }
    
    public function toggle() {
        // M: Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['id']) {
            // M: Check if the ticket with the given id exists;
            $this->query('SELECT * FROM ticket WHERE id = :id');
            $this->bind(':id', $post['id']);
            if ($ticket = $this->single()) {
                // M: If so, we toggle the status;
                $newStatus = $ticket['status'] ? '0' : '1';
                $this->query('UPDATE ticket SET status = :status WHERE id = :id');
                $this->bind(':id', $post['id']);
                $this->bind(':status', $newStatus);
                $this->execute();
                $status = $ticket['status'] ? 'closed' : 'open';
                Messages::setMsg("Status changed with success. The ticket is now $status.", 'success');
                return true;
            } else {
                Messages::setMsg('Invalid ticket.', 'error');
                return false;
            }
        } else {
            header('Location: ' . ROOT_URL . 'ticket/viewtickets');
            Messages::setMsg('Illegal try to access the page.', 'error');
        }
    }
}
