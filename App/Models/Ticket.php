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
                    $SESSION['iAuthor'] = true;
                    //Messages::setMsg($text, $type)
                    header('Location: ' . ROOT_URL);
                } else {
                    // M: Fail message and retry;
                    //Messages::setMsg($text, $type);
                }
            }
        }
        return $departments;
    }

}
