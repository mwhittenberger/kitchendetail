<?php

class B2S_Form {

    public static function getNetworkBoardAndGroupHtml($data) {
        $collection = '<select class="form-control b2s-select" id="b2s-modify-board-and-group-network-selected">';
        $collection .= $data;
        $collection .= '</select>';
        return $collection;
    }
}
