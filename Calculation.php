<?php

	$quarters = getQuartersBetweenQuarters(2019, 2021, 4, 1);

	print_r($quarters);

 function getQuartersBetweenQuarters($from_fy, $to_fy, $from_quarter, $to_quarter){

        
        //Calculate the quarters
        
        $from_quarter_start_month = 0;
        $from_quarter_end_month = 0;
        $to_quarter_end_month = 0;
        $to_quarter_start_month = 0;

        $is_prev_yr = false;

        //If the quarter is less than 4 then start year is decresed by 1. Example for 3rd quarter of FY-19 , start month will be 10 -2018
        if ($from_quarter < 4) {
            $is_prev_yr = true;            
        }

        if ($from_quarter == 1) {
            $from_quarter_start_month = 4;
            $from_quarter_end_month = 6;

        } else if ($from_quarter == 2) {
            $from_quarter_start_month = 7;
            $from_quarter_end_month = 9;

        } else if ($from_quarter == 3) {
            $from_quarter_start_month = 10;
            $from_quarter_end_month = 12;

        } else if ($from_quarter == 4) {

            $from_quarter_start_month = 1;
            $from_quarter_end_month = 3;
        }

        if ($to_quarter == 1) {
            $to_quarter_start_month = 4;
            $to_quarter_end_month = 6;

        } else if ($to_quarter == 2) {
            $to_quarter_start_month = 7;
            $to_quarter_end_month = 9;

        } else if ($to_quarter == 3) {
            
            $to_quarter_start_month = 10;
            $to_quarter_end_month = 12;

        } else if ($to_quarter == 4) {
            $to_quarter_start_month = 1;
            $to_quarter_end_month = 3;

        }

        

        $from_date = new DateTime();
        $to_date = new DateTime();

        //Get the start and end date of the entire report
        // Start date = 1st day of the given start quarter
        if ($is_prev_yr) {
            $from_date->setDate((int)$from_fy - 1, $from_quarter_start_month, 1);
            $to_date->setDate((int)$to_fy - 1, $to_quarter_end_month, 1);
        } else {
            $from_date->setDate((int)$from_fy, $from_quarter_start_month, 1);    
            $to_date->setDate((int)$to_fy -1, $to_quarter_end_month, 1);
        }
        

        //End date = Last day of the given end quarter
        $to_date = new DateTime($to_date->format("Y-m-t"));

        //Calculate the start and end for the starting quarter
        $quarter_start = new DateTime($from_date->format("Y-m-d"));
        $quarter_end = new DateTime($from_date->format("Y-m-d"));
        $quarter_end->modify("+3 month");
        $quarter_end->modify("-1 day");

        //Loop through till the $enddate becomes equal to the to_date. 
        //Once they are equal it means we have finished the cycle for the calculating the quarters
        $quarters = array();

        
        while ($to_date >= $quarter_end) {
            
            $year = $quarter_start->format("y");
            $full_year = $quarter_start->format("Y");
            $month = $quarter_start->format("m");

            $quarter_num = 0;
            if ($month == 1) {
                $quarter_num = 4;
            } else if ($month == 4) {
                $quarter_num = 1;
                // $year += 1;
                // $full_year += 1;
            } else if ($month == 7) {
                $quarter_num = 2;
                // $year += 1;
                // $full_year += 1;
            } else if ($month == 10) {
                $quarter_num = 3;
                // $year += 1;
                // $full_year += 1;
            }

            $term_text = "FY" . $year . " - Q" . $quarter_num;

            
            $q_detail = array();
            $q_detail["TimeUnit"] = $term_text;
            $q_detail["start_date"] = $quarter_start->format("Y-m-d");
            $q_detail["end_date"] = $quarter_end->format("Y-m-d");

            array_push($quarters, $q_detail);

            

            //Get the start date of the next quarter
            $quarter_start->modify("+3 month");
            //Get the end date of the next quarter
            $quarter_end = new DateTime($quarter_start->format("Y-m-d"));
            $quarter_end->modify("+3 month");
            $quarter_end->modify("-1 day");

        }






        // print_r($quarters);

        return $quarters;

    }

?>