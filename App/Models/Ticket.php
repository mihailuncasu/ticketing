<?php

//namespace App\Models;

class TicketModel extends Model {

    // M: Create a ticket;
    public function create() {
        // M: Get the departments and the pass to the view;
        $this->query("SELECT * FROM departments");
        $departments = $this->resultSet();
        // M: Check if the ticket was subbmited
        // M: Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $status = '';
        
        $errors = [];
        if ($post['submit']) {
            
            // M: Subject field error;
            if (empty($post['subject'])) {
                array_push($errors, 'Subject field is empty');
            }
            
            // M: Email field error;
            if (empty($post['email'])) {
                array_push($errors, 'Email field is empty');
            }
            
            // M: Message field error;
            if (!empty($post['Message'])) {
                array_push($errors, 'Message field is empty');
            }

            // M: Make a qt string from the array;
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
                    header('Location: ' . ROOT_URL . 'ticket/view/' . str_replace('-', '_', $referenceField));
                    $status = 'success';
                } else {
                    // M: Fail message and retry;
                    $status = 'fail';
                }
            }
        }
        return [
            'departments' => $departments,
            'status' => $status
        ];
    }
    
    // M: View all tickets;
    public function viewTickets() {
        // M: Store the info that we accesed the admin page;
        $_SESSION['iAuthor'] = 0;
        
        // M: Get all departments;
        $this->query("SELECT * FROM departments");
        $departments = $this->resultSet();
        array_unshift($departments, ['id' => '-1', 'name' => 'All']);
        
        // M: For the filter dropdown;
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
    
    // M: View ticket;
    public function view() {
        // M: Sanitize post & get;
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        if (empty($get['reference']) || !isset($_SESSION['iAuthor'])) {
            // M: This means that the page for the ticket has been accesed by another person so we will redirect;
            header('Location: ' . ROOT_URL . 'ticket/viewtickets');
            $status = 'fail';
        }
        $status = '';
        $messages = [];
        
        // M: Add a new reply for this ticket;
        if ($post['submit']) {
            $this->query('INSERT INTO replies (message, ticket_reference, iAuthor, date) VALUES (:message, :ticket_reference, :iAuthor, :date)');
            $this->bind(':message', $post['message']);
            $this->bind(':ticket_reference', $post['reference']);
            $this->bind(':iAuthor', $_SESSION['iAuthor']);
            $this->bind(':date', date("Y-m-d H:i:s"));
            $this->execute();
            
            if ($this->lastInsertId()) {
                // M: Reply was posted with success;
                Messages::setMsg('Your reply was posted with success', 'success');
            } else {
                // M: Something went wrong;
                Messages::setMsg('Something went wrong. Please try again.', 'error');
            }
        }
        
        // M: Get the ticket;
        $this->query('SELECT * FROM ticket WHERE reference = :reference');
        $this->bind(':reference', str_replace('_', '-', $get['reference']));
        $ticket = $this->single();
                
        // M: If empty we show a properly message and redirect the user to the list;
        if (empty($ticket)) {
            header('Location: ' . ROOT_URL . 'ticket/viewtickets');
            $status = 'fail';
        } else {
            // M: Get that department name;
            $this->query('SELECT name FROM departments WHERE id = :id');
            $this->bind(':id', $ticket['id_department']);
            $ticket['department'] = $this->single();
            // M: Now we must get all the messages related to this ticket;
            $this->query('SELECT * FROM replies WHERE ticket_reference = :reference');
            $this->bind(':reference', $ticket['reference']);
            $messages = $this->resultSet();
        }
        
        return [
            'ticket' => $ticket,
            'status' => $status,
            'messages' => $messages
        ];
    }
    
    // M: Delete ticket;
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
                
                // M: And also the messages;
                $this->query('DELETE FROM replies WHERE ticket_reference = :reference');
                $this->bind(':reference', $ticket['reference']);
                $this->execute();
                
                Messages::setMsg("Ticket deleted with success. Also all replies related to this ticket have been removed.", 'success');
                return true;
            }
        } else {
            header('Location: ' . ROOT_URL . 'ticket/viewtickets');
            Messages::setMsg('Illegal try to access the page.', 'error');
        }
    }
    // M: Open/close ticket;
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
