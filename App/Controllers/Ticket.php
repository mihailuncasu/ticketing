<?php
//namespace App\Controllers;

class Ticket extends Controller {

    protected function create() {
        $viewmodel = new TicketModel();
        $data = $viewmodel->create();
        $this->returnView($data, true);
        if ($data['status'] == 'success') {
            Messages::setMsg('Ticket created. Have a look.', 'success');   
        } elseif ($data['status'] == 'fail') {
            Messages::setMsg('Ups, there was a problem with your ticket.', 'error'); 
        }
    }
    
    protected function viewTickets() {
        $viewmodel =  new TicketModel();
        $this->returnView($viewmodel->viewTickets(), true);
    }
    
    protected function view() {
        $viewmodel =  new TicketModel();
        $data = $viewmodel->view();
        $this->returnView($data, true);
        if ($data['status'] == 'fail') {
            Messages::setMsg('Invalid reference value for the ticket. Try again.', 'error');
        }
    }
    
    protected function toggle() {
        $viewmodel =  new TicketModel();
        if ($viewmodel->toggle()) {
            echo json_encode([
                'status' => 'success'
            ]);
        } else {
            echo json_encode([
                'status' => 'fail'
            ]);
        }
    }
    
    protected function delete() {
        $viewmodel =  new TicketModel();
        if ($viewmodel->delete()) {
            echo json_encode([
                'status' => 'success'
            ]);
        } else {
            echo json_encode([
                'status' => 'fail'
            ]);
        }
    }
    
}