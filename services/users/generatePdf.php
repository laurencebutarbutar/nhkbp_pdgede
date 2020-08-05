<?php    
    require('../../assets/class/pdf/fpdf.php');
    session_start();

    $totalPayHidden = $_SESSION['total_payment'];
    $nameFoodNew = $_SESSION['nameFoodNew'];
    $priceFoodNew = $_SESSION['price_unit'];
    $qtyFoodNew = $_SESSION['quantity'];

    $nameTemp = $_SESSION['fullName'];
    $phone = $_SESSION['phone'];;
    $deliveryDate = $_SESSION['delivery_date'];        
    $addressTemp = $_SESSION['address'];
    $tempNote = $_SESSION['note'];
    $lastIdOrder = $_SESSION['lastIdOrder'];

    $jmlhName = strlen($nameTemp);
    $jmlhAddress = strlen($addressTemp);

    if($jmlhName>26){
        $name = substr($nameTemp,0, 26);
    }else{
        $name = $nameTemp;
    }

    if($jmlhAddress>240){
        $address = substr($addressTemp,0, 240);
    }else{
        $address = $addressTemp;
    }

    $jmlhNote = strlen($tempNote);
    if($jmlhNote>228){
        $note = substr($tempNote,0, 228);
    }else{
        $note = $tempNote;
    }

    $filename="../../assets/pdf/".$lastIdOrder.".pdf";
    
    function rupiah($angka){            
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = substr($hasil_rupiah, 0, strlen($hasil_rupiah)-3);
        return $hasil_rupiah;
    }

    $pdf = new FPDF( 'P', 'mm', 'A4' );

    $var_id_facture = $_GET['id_param'];

    $pdf->SetAutoPagebreak(False);
    $pdf->SetMargins(0,0,0);

    $nb_page = 1;

    $num_page = 1; $limit_inf = 0; $limit_sup = 18;
    
    $pdf->AddPage();
    
    $pdf->Image('../../assets/img/pdf/logoHkbp.jpg', 15, 10, 27, 31);
    $pdf->Image('../../assets/img/pdf/logo2018.jpg', 68, 10, 27, 31);
    $pdf->Image('../../assets/img/pdf/logoPdf.jpg', 15, 45, 80, 20);

    $pdf->SetXY( 120, 5 ); $pdf->SetFont( "Arial", "B", 12 ); $pdf->Cell( 150, 8, 'Page: '.$num_page . '/' . $nb_page, 0, 0, 'C');
    
    $num_fact ="Order Number: ".$lastIdOrder;
    $pdf->SetLineWidth(0.1); $pdf->SetFillColor(192); $pdf->Rect(120, 15, 85, 8, "DF");
    $pdf->SetXY( 120, 15 ); $pdf->SetFont( "Arial", "B", 12 ); $pdf->Cell( 85, 8, $num_fact, 0, 0, 'C');
    
    $date_fact = date("d-F-Y");
    $pdf->SetFont('Arial','',11); $pdf->SetXY( 120, 30 );
    $pdf->Cell( 60, 8, "Bekasi, " . $date_fact, 0, 0, '');
            
    $pdf->SetFont( "Arial", "BU", 11 ); $pdf->SetXY( 5, 75 ) ; $pdf->Cell($pdf->GetStringWidth("Observations"), 0, "*Note Order : ", 0, "L");
    
    $pdf->SetFont( "Arial", "", 10 ); $pdf->SetXY( 5, 78 ) ; $pdf->MultiCell(115, 4, $note, 0, "L");
 
    $pdf->SetFont('Arial','B',11); $pdf->SetXY( 120, 40 );
    $pdf->Cell( 200, 8, "Name", 0, 0, '');
    $pdf->SetFont('Arial','',11); $pdf->SetXY( 145, 40 );
    $pdf->Cell( 200, 8, ": " . $name, 0, 0, '');

    $pdf->SetFont('Arial','B',11); $pdf->SetXY( 120, 45 );
    $pdf->Cell( 200, 8, "Phone", 0, 0, '');
    $pdf->SetFont('Arial','',11); $pdf->SetXY( 145, 45 );
    $pdf->Cell( 200, 8, ": " . $phone, 0, 0, '');

    $pdf->SetFont('Arial','B',11); $pdf->SetXY( 120, 50 );
    $pdf->Cell( 200, 8, "Delivery Date", 0, 0, '');
    $pdf->SetFont('Arial','',11); $pdf->SetXY( 145, 50 );
    $pdf->Cell( 200, 8, ": " . $deliveryDate, 0, 0, '');

    $pdf->SetFont('Arial','B',11); $pdf->SetXY( 120, 55 );
    $pdf->Cell( 200, 8, "Address", 0, 0, '');
    $pdf->SetFont('Arial','',11); $pdf->SetXY( 145, 55 );
    $pdf->Cell( 200, 8, ":", 0, 0, '');
    $pdf->SetFont('Arial','',11); $pdf->SetXY( 120, 62 );
    $pdf->MultiCell( 85, 5, $address, 0, 'L');

    $pdf->SetXY( 1, 96 ); $pdf->SetFont('Arial','B',11); $pdf->Cell( 20, 11, "No", 0, 0, 'C');
    $pdf->SetXY( 20, 96 ); $pdf->SetFont('Arial','B',11); $pdf->Cell( 85, 11, "Name ", 0, 0, 'C');
    $pdf->SetXY( 105, 96 ); $pdf->SetFont('Arial','B',11); $pdf->Cell( 25, 11, "Quantity", 0, 0, 'C');
    $pdf->SetXY( 130, 96 ); $pdf->SetFont('Arial','B',11); $pdf->Cell( 30, 11, "Price", 0, 0, 'C');
    $pdf->SetXY( 160, 96 ); $pdf->SetFont('Arial','B',11); $pdf->Cell( 45, 11, "Subtotal", 0, 0, 'C');
    
    $pdf->SetFont('Arial','',11);
    $y = 97;

    for($x=0; $x<count($nameFoodNew); $x++){
        $tempTotal = null;
        $tempTotal = ((int)$qtyFoodNew[$x])*((int)$priceFoodNew[$x]);
        //No
        $pdf->SetXY( 1, $y+9 ); $pdf->Cell( 20, 5, ((int)$x)+1, 0, 0, 'C');
        //Nama
        $pdf->SetXY( 20, $y+9 ); $pdf->Cell( 85, 5, $nameFoodNew[$x], 0, 0, 'L');
        //Quantity
        $pdf->SetXY( 105, $y+9 ); $pdf->Cell( 25, 5, $qtyFoodNew[$x], 0, 0, 'C');
        //Price
        $pdf->SetXY( 130, $y+9 ); $pdf->Cell( 30, 5, rupiah($priceFoodNew[$x]), 0, 0, 'C');
        //Subtotal
        $pdf->SetXY( 160, $y+9 ); $pdf->Cell( 45, 5, rupiah($tempTotal), 0, 0, 'R');
        $y += 6;
    }

    $botLine = $y+10;
    $highLine = $botLine - 95;
    //line vertical for table

    $pdf->SetLineWidth(0.1); $pdf->Rect(5, 95, 200, $highLine, "D");
    $pdf->Line(5, 105, 205, 105);
    $pdf->Line(20, 95, 20, $botLine); 
    $pdf->Line(105, 95, 105, $botLine);
    $pdf->Line(130, 95, 130, $botLine); 
    $pdf->Line(160, 95, 160, $botLine);

    $pdf->SetLineWidth(0.1); $pdf->SetFillColor(192); $pdf->Rect(5, $botLine, 155, 8, "DF");
    $pdf->Rect(160, $botLine, 45, 8, "D"); 

    $pdf->SetFont('Arial','B',12); $pdf->SetXY( 105, $botLine ); $pdf->Cell( 55, 8, "Total Payment", 0, 0, 'C');

    $pdf->SetFont('Arial','B',12); $pdf->SetXY( 160, $botLine ); $pdf->Cell( 45, 8, rupiah($totalPayHidden), 0, 0, 'R');

    //box botom end
    $boxBottomEnd = $botLine + 20;
    $pdf->SetLineWidth(0.1); $pdf->Rect(5, $boxBottomEnd, 200, 8, "D");
    $pdf->SetXY( 1, $boxBottomEnd ); $pdf->SetFont('Arial','B',11);
    $pdf->Cell( $pdf->GetPageWidth(), 8, "This Is End Of Your Order", 0, 0, 'C');
    
    $y1 = $boxBottomEnd + 10;

    $pdf->SetXY( 1, $y1 ); $pdf->SetFont('Arial','B',10);
    $pdf->Cell( $pdf->GetPageWidth(), 5, "Thank Your For Ordering From Us", 0, 0, 'C');
    
    $pdf->SetFont('Arial','',10);    
    $pdf->SetXY( 1, $y1 + 4 ); 
    $pdf->Cell( $pdf->GetPageWidth(), 5, "Contact Person :", 0, 0, 'C');
    
    $pdf->SetXY( 1, $y1 + 8 );
    $pdf->Cell( $pdf->GetPageWidth(), 5, "Richard Sahala Tamba : 0813 1915 7897", 0, 0, 'C');

    $pdf->SetXY( 1, $y1 + 12 );
    $pdf->Cell( $pdf->GetPageWidth(), 5, "Yeftah Christanto Sihombing : 0878 8448 3901", 0, 0, 'C');

    $pdf->SetXY( 1, $y1 + 16 );
    $pdf->Cell( $pdf->GetPageWidth(), 5, "www.nhkbp-pdgede.com", 0, 0, 'C');
        
    // $pdf->Output();
    $pdf->Output($filename,'F');
    header("Location: sentEmailOrder.php");
?>