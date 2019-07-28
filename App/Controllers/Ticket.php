<?php
//namespace App\Controllers;

class Ticket extends Controller {

    protected function create() {
        $viewmodel = new TicketModel();
        $this->returnView($viewmodel->create(), true);
    }
    
    protected function viewTickets() {
        $viewmodel =  new TicketModel();
        $this->returnView($viewmodel->viewTickets(), true);
    }
    
    protected function view() {
        $viewmodel =  new TicketModel();
        $this->returnView($viewmodel->view(), true);
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