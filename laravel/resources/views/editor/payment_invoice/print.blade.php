<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kwitansi Pembayaran IPL</title>
    
    <style>

    .invoice-box {
        max-width: 8.5in;
        margin: auto;
        padding: 5px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 12px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    /* .invoice-box table tr td:nth-child(2) {
        text-align: right;
    } */
    
    
    .invoice-box table tr.top table td {
        padding-bottom: 5px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: -15px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 10px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }

    @media print 
    {
        .btnprint {display:none;}

        @page
        {
            size: 8.5in 5.5in;
            margin: 0cm;
            thead {display: table-header-group;
        }
    }
</style>

<style>
    div.a {
    -webkit-text-decoration-line: overline; /* Safari */
    text-decoration-line: overline; 
    }

    div.b {
    -webkit-text-decoration-line: underline; /* Safari */
    text-decoration-line: underline; 
    }

    div.c {
    -webkit-text-decoration-line: line-through; /* Safari */
    text-decoration-line: line-through; 
    }

    div.d {
    -webkit-text-decoration-line: overline underline; /* Safari */
    text-decoration-line: overline underline; 
    }
</style>
</head>

<?php
	function konversi_bulan($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}	

	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "JANUARI";
						break;
					case 2:
						return "FEBRUARI";
						break;
					case 3:
						return "MARET";
						break;
					case 4:
						return "APRIL";
						break;
					case 5:
						return "MEI";
						break;
					case 6:
						return "JUNI";
						break;
					case 7:
						return "JULI";
						break;
					case 8:
						return "AGUSTUS";
						break;
					case 9:
						return "SEPTEMBER";
						break;
					case 10:
						return "OKTOBER";
						break;
					case 11:
						return "NOVEMBER";
						break;
					case 12:
						return "DESEMBER";
						break;
				}
			} 
?>

<body>
    <div class="invoice-box">
        <div class="btnprint">
            <button class="btn btn-primary" onClick="window.print();">
            &nbsp;&nbsp;PRINT
            </button>
        </div>
        <table cellpadding="0" cellspacing="0">
            
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ url('/assets/plugins/images') }}/logo.jpg" style="width:130%;">
                            </td>
                            
                            <td>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="3">
                    <table style="margin-top:-30px !important">
                        <tr>
                            <td>
                                <b>No &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: {{ $data_header_ipl->transaction_no }}</b><br>
                                <b>Tanggal &nbsp;: {{ $data_header_ipl->transaction_date }}</b><br>
                                Nama  &nbsp;  &nbsp;  &nbsp;: {{ $data_header_ipl->name }}<br>
                            </td>

                            <td>
                                RT &nbsp;  &nbsp;  &nbsp;  &nbsp;: {{ $data_header_ipl->rt_name }}<br> 
                                Alamat  &nbsp;: {{ $data_header_ipl->address }}<br>
                                Blok &nbsp; &nbsp; &nbsp;: {{ $data_header_ipl->block }}<br>
                            </td>
                            
                            <td>
                                ID IPL &nbsp; &nbsp; &nbsp; &nbsp;: {{ $data_header_ipl->ipl_id }}<br>
                                Jenis Bayar: {{ $data_header_ipl->payment_type_name }} <br>
                                Keterangan: {{ $data_header_ipl->description }} <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            
            <tr class="heading">
                <td>
                    NO
                </td>
                <td>
                    Periode Pembayaran
                </td>
                
                <td width="20%">
                    Nominal
                </td>
            </tr>
            @php 
                $total = 0;
                $i = 1;
            @endphp
            @foreach($data_ipl AS $data_ipls)
                <tr class="item">
                    <td>
                        @php echo $i++; @endphp
                    </td>
                    <td>
                        PEMBAYARAN IPL BULAN <?php echo getBulan($data_ipls->month);?> TAHUN {{ $data_ipls->year }}
                    </td>
                    
                    <td style="text-align: right">
                        Rp {{ number_format($data_ipls->ipl_tarif - $data_ipls->unique_code) }}
                    </td>
                </tr>
                @php
                    $total += $data_ipls->ipl_tarif  - $data_ipls->unique_code
                @endphp
            @endforeach 
            
            <tr class="total">
                <td></td>
                <td></td>
                <td style="text-align: right">
                   Total: Rp {{ number_format($total + $data_header_ipl->unique_code) }}
                </td>
            </tr>


            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td colspan="2">
                                <b> <p style="margin-top: -30px !important"> Info: </b>
                                @if(isset($data_header_ipl_outstanding))
                                   <b>Tunggakan sampai bulan ini: Rp {{ $data_header_ipl_outstanding->total_tarif_ipl }} ({{ $data_header_ipl_outstanding->tunggakan }}) </b>
                                @else
                                    <b>Tidak ada tunggakan sampai bulan ini </b>
                                @endif
                                    <br>
                                    <b>Tagihan Tahun 2019 : Rp {{ number_format($data_header_ipl->bill_2019) }} </b>
                                </p>
                                <p style="margin-top: -10px !important"><b>Pembayaran IPL ditransfer ke rekening RW </b> <br/>
                                BCA : 5680484041<br/>
                                An : PEMBERDAYAAN RW13 </p>

                                <p  style="margin-top: -10px !important">Mandiri : 1670017177170 <br>
                                An : LEMBAGA PEMBERDAYAAN RW 13 </p>

                                <p style="font-size: 11px; margin-top: -15px"> <i> Saat transfer jangan lupa masukkan 3 angk ID IPL dibelakang jumlah transfer. </i> </p>
                            </td>
                            
                            
                            <td style="text-align: right">
                                Hormat Kami, <br/>
                                <img src="{{Config::get('constants.path.plugin')}}/images/ttd.png" style="width: 150px; height: 77px;" alt="home" />
                                <div class="a">Bendahara / Admin IPL</div>
                                @php
                                $mytime = Carbon\Carbon::now();
                                $mytimeclock = Carbon\Carbon::now()->format('H::d');
                                @endphp
                                <p style="font-size: 10px;  margin-top: -10px"> Tgl cetak : @php echo $mytime; @endphp  </p>
                                <p style="font-size: 10px; margin-top: -20px"><b>Humas RW 013 </b> HP : 0816 10 8595 | email : rw13ceriakp3@gmail.com</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>