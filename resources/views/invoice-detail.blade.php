<!DOCTYPE html>
<html lang="id">

<head>
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        @media print {
            body {
                padding-top: 0;
            }

            #action-area {
                display: none;
            }
        }

        @media screen and (min-width: 1025px) {
            .btn-download {
                display: none !important;
            }

            .btn-back {
                display: none !important;
            }
        }

        @media screen and (max-width: 1024px) {
            .content-area>div {
                width: auto !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 720px) {
            .content-area>div {
                width: auto !important;
            }
        }

        @media screen and (max-width: 420px) {
            .content-area>div {
                width: 840px !important;
            }
        }

        @media screen and (max-width: 430px) {
            .content-area {
                transform: scale(0.59) translate(-35%, -35%)
            }

            .content-area>div {
                width: 720px !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 380px) {
            .content-area {
                transform: scale(0.45) translate(-58%, -62%);
            }

            .content-area>div {
                width: 840px !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 320px) {
            .content-area>div {
                width: 700px !important;
            }
        }
    </style>
</head>

<body
    style="font-family: open sans, tahoma, sans-serif; margin: 0; -webkit-print-color-adjust: exact; padding-top: 60px;">

    <div id="action-area">
        <div id="navbar-wrapper"
            style="padding: 12px 16px;font-size: 0;line-height: 1.4; box-shadow: 0 -1px 7px 0 rgba(0, 0, 0, 0.15); position: fixed; top: 0; left: 0; width: 100%; background-color: #FFF; z-index: 100;">
            <div style="width: 50%; display: inline-block; vertical-align: middle; font-size: 12px;">
                <div class="btn-back" onclick="window.close();">
                    <img src="https://ik.imagekit.io/prbydmwbm8c/back-invoice_i7gwWzSsX.png" width="20px" alt="Back"
                        style="display: inline-block; vertical-align: middle;" />
                    <span
                        style="display: inline-block; vertical-align: middle; margin-left: 16px; font-size: 16px; font-weight: bold; color: rgba(49, 53, 59, 0.96);">Invoice</span>
                </div>
            </div>
            <div style="width: 50%; display: inline-block; vertical-align: middle; font-size: 12px; text-align: right;">
                <a class="btn-download" href="javascript:window.print()"
                    style="display: inline-block; vertical-align: middle;">
                    <img src="https://ik.imagekit.io/prbydmwbm8c/download-invoice_9Til6kHZW.png" alt="Download"
                        width="20px" ; />
                </a>
                <a class="btn-print" href="javascript:window.print()"
                    style="height: 100%; display: inline-block; vertical-align: middle;">
                    <button id="print-button"
                        style="border: none; height: 100%; cursor: pointer;padding: 8px 40px;border-color: #0c62e2;border-radius: 8px;background-color: #0c62e2;margin-left: 16px;color: #fff;font-size: 12px;line-height: 1.333;font-weight: 700;">Cetak</button>
                </a>
            </div>
        </div>
    </div>


    <div class="content-area">

        <div style="margin: auto; width: 840px;">
            <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding: 25px 32px;">
                <tr>
                    <td>
                        <!-- header -->
                        <table width="100%">
                            <tr>
                                <td style="text-align: center;">
                                    <img src="https://ik.imagekit.io/prbydmwbm8c/logo_OKk7cDMhjEg.png" width="120"
                                        alt="Kawaii Apartemen" style="margin-top: -23px;">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>



        <div style="background-size: contain; margin: auto; width: 840px;">

            <table width="100%" cellspacing="0" cellpadding="0"
                style="width: 100%; padding: 25px 32px; color: #343030;">
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0"
                            style="padding-bottom: 20px; border-bottom: thin dashed #cccccc;">
                            <tr>
                                <td style="width: 57%; vertical-align: top;">
                                    <table width="100%" cellspacing="0" cellpadding="0">

                                        <tr>
                                            <td colspan="2" style="font-size: 14px;">
                                                <span style="font-weight: 600">Nomor Invoice</span> : <span
                                                    style="color: #0c62e2; font-weight: 600;">{{ $inv->inv }}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td
                                                style="font-size: 12px; font-weight: 600; padding-bottom: 6px; width: 120px; padding-top: 15px;">
                                                Tanggal Bayar</td>
                                            <td style="font-size: 12px; padding-bottom: 6px; padding-top: 15px;">
                                                {{ date('d F Y', strtotime($inv->updated_at)) }}</td>
                                        </tr>




                                    </table>
                                </td>
                                <td style="width: 43%; vertical-align: top; padding-left: 30px;">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="font-weight: 600; font-size: 14px;padding-bottom: 8px;">
                                                Identitas Pembeli:</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; padding-bottom: 20px;">
                                                <span style="margin-bottom: 3px; font-weight: 600; display: block;">{{
                                                    $inv->nama }}</span>
                                                <div>
                                                    {{ $inv->nik }}
                                                    <br>
                                                    {{ $inv->no_telepon }}
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0"
                            style="border: thin dashed rgba(0, 0, 0, 0.34); border-radius: 4px; color: #343030; margin-top: 20px;">
                            <tr style="background-color: rgba(242, 242, 242, 0.74); font-size: 14px; font-weight: 600;">
                                <td style="padding: 10px 15px;">Kamar</td>
                                <td style="padding: 10px 15px; text-align: center;">Checkin</td>
                                <td style="padding: 10px 15px; text-align: center;">Checkout</td>
                                <td style="padding: 10px 15px; text-align: center; white-space: nowrap;">Hari</td>
                                <td style="padding: 10px 15px; text-align: right;">Total Harga</td>
                            </tr>


                            <!-- looping -->
                            <tr style="font-size: 14px;">
                                <td width="330" style="padding: 15px; font-weight: 600; word-break: break-word;">
                                    {{ $inv->room->jenis }}

                                    <div style="margin: 10px 0 0;">

                                    </div>



                                </td>
                                <td valign="top" style="padding: 15px; text-align: center;">
                                    {{ date('j F Y', strtotime($inv->checkin))  }}
                                </td>
                                <td valign="top" style="padding: 15px; text-align: center;">
                                    {{ date('j F Y', strtotime($inv->checkout))  }}
                                </td>
                                <td valign="top" style="padding: 15px; white-space: nowrap; text-align: center;">
                                    {{ $inv->hari }}
                                </td>
                                <td valign="top" style="padding: 15px; white-space: nowrap; text-align: right;">
                                    Rp {{ number_format($inv->harga * $inv->hari, 0, ',', '.') }}
                                </td>
                            </tr>


                            <tr>
                                <td colspan="5" style="padding: 0 15px;">
                                    <div style="border-bottom: thin solid #e0e0e0"></div>
                                </td>
                            </tr>
                            <!-- end looping -->

                        </table>
                    </td>
                </tr>

                <!-- refactor div float left and right in case order is kelontong -->
                <tr>
                    <td>
                        <div id="container_invoice_qr" style="float:left; font-weight: bold;
                                    margin-top:20px;">

                        </div>

                        <div style="float:right;">
                            <table>

                                <!-- total belanja -->

                                <tr>
                                    <td>
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="width: 50%;"></td>
                                                <td style="width: 50%;">
                                                    <table width="100%"
                                                        style="width: 430px; margin-top: 15px; padding: 15px; border-radius: 4px; border: thin solid rgba(0, 0, 0, 0.54); font-size: 14px; font-weight: 600;">
                                                        @if(!is_null($code))
                                                        <tr>
                                                            <td>Promo Code</td>
                                                            <td style="text-align: right;">
                                                                {{ $code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Diskon</td>
                                                            <td style="text-align: right;">
                                                                Rp {{ number_format($diskon, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td>Total Bayar</td>
                                                            <td style="text-align: right;">
                                                                Rp {{ number_format($inv->total_harga, 0, ',', '.') }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                                <!-- subtotal nilai tukar tambah -->



                                <!-- subtotal nilai promo -->

                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>


</html>