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
}