<?php
//namespace App\Controllers;

class Ticket extends Controller {

    protected function Index() {
        $viewmodel = new TicketModel();
        $this->returnView($viewmodel->create(), true);
    }

}