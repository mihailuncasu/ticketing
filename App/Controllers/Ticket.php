<?php
//namespace App\Controllers;

class Ticket extends Controller {

    protected function create() {
        $viewmodel = new TicketModel();
        $this->returnView($viewmodel->create(), true);
    }

}