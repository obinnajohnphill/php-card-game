<?php

class BoardController
{
    private $css = array();
    private $cards = array();
    private $cards_names = array();
    private $cols = 0;
    private $rows = 0;
    private $modes = array(6, 8, 10, 12, 15, 18);

    function __construct($level, $card_files) {
        $num_of_cards = $this->modes[$level - 1];

        // Shuffle the cards available so we won't pick the
        // same ones every time
        shuffle($card_files);
        // Get the card objects
        $cards = array();
        for ( $i = 0; $i < $num_of_cards; ++$i ){
            $cards[$i] = new CardController($card_files[$i]);
            $this->css[] = $cards[$i]->get_css_block();
        }
        // Double the array so we will have pairs
        $this->cards = array_merge($cards, $cards);

        // Shuffle the cards to create the order on the board
        shuffle($this->cards);

        // Get the number of cols
        $num = count($this->cards);
        $sr = sqrt($num);
        $this->rows = floor($sr);
        while ( $num % $this->rows ){
            --$this->rows;
        }
        $this->cols = $num / $this->rows;
    }

    function max_level(){
        return count($this->modes);
    }

    function get_css(){
        return implode("\n",$this->css);
    }

    function debug_print(){
        $p_rslt = array("cards"=>$this->cards, "rows"=>$this->rows, "cols"=>$this->cols);
        print "<br/ >".json_encode($p_rslt);
    }

    function get_rows(){
        return $this->rows;
    }

    function get_cols(){
        return $this->cols;
    }

    function get_cards(){
        return $this->cards;
    }


    function get_size(){
        return count($this->cards);
    }

    function get_card($index){
        return $this->cards[$index];
    }

    function get_html(){
        // For each card
        for ( $i = 0 ; $i < $this->get_size() ; ++$i ){
            // Check if it's time for a new row
            if ( ($i % $this->get_cols()) == 0 ){
                print "\r<div class=\"clear\"></div>";
            }
            print $this->get_card($i)->get_html_block();
        }
        return null;
    }
}
