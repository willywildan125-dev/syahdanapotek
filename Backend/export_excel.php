<?php
require_once 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Transaksi_Apotek_Syahdan.xls");
header("Pragma: no-cache");
header("Expires: 0");

$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : '';

$where_clause = "";
if ($start_date && $end_date) {
    $where_clause = "WHERE DATE(n.tgl_penjualan) BETWEEN '$start_date' AND '$end_date'";
} elseif ($start_date) {
    $where_clause = "WHERE DATE(n.tgl_penjualan) >= '$start_date'";
} elseif ($end_date) {
    $where_clause = "WHERE DATE(n.tgl_penjualan) <= '$end_date'";
}

$query = mysqli_query($conn, "
    SELECT 
        n.no_nota,
        n.tgl_penjualan,
        n.total_harga,
        d.jumlah_beli,
        o.nama_obat,
        o.harga_jual,
        (d.jumlah_beli * o.harga_jual) as subtotal
    FROM nota_penjualan n
    JOIN detail_penjualan d ON n.no_nota = d.no_nota
    JOIN obat o ON d.kode_obat = o.kode_obat
    $where_clause
    ORDER BY n.tgl_penjualan ASC, n.no_nota ASC
");

if ($start_date && $end_date) {
    $periode_text = date('d/m/Y', strtotime($start_date)) . " - " . date('d/m/Y', strtotime($end_date));
} elseif ($start_date) {
    $periode_text = "Sejak " . date('d/m/Y', strtotime($start_date));
} elseif ($end_date) {
    $periode_text = "Hingga " . date('d/m/Y', strtotime($end_date));
} else {
    $periode_text = "Semua Periode";
}

$total_keseluruhan = 0;
$total_jumlah = 0;
$total_transaksi = 0;
$current_nota = "";
$no = 1;

$html = "";
$html .= "<table border='1' style='border-collapse: collapse; font-family: sans-serif;'>";
$html .= "<tr><td colspan='8' style='text-align: center; font-weight: bold; font-size: 16pt; color: #003366; border: none; padding-bottom: 10px;'>LAPORAN TRANSAKSI PENJUALAN</td></tr>";
$html .= "<tr><td colspan='8' style='text-align: center; color: #009933; border: none;'>Apotek Syahdan</td></tr>";
$html .= "<tr><td colspan='8' style='text-align: center; color: #009933; border: none; padding-bottom: 15px;'>" . htmlspecialchars($periode_text) . "</td></tr>";
$html .= "<tr><td colspan='8' style='text-align: left; font-style: italic; color: #888888; border: none; padding-bottom: 5px;'>Dicetak pada: " . date('d/m/Y H:i:s') . "</td></tr>";

$html .= "<tr>";
$html .= "<th style='background-color: #2b5f9e; color: #ffffff; text-align: center; padding: 8px;'>No</th>";
$html .= "<th style='background-color: #2b5f9e; color: #ffffff; text-align: center; padding: 8px;'>No. Nota</th>";
$html .= "<th style='background-color: #2b5f9e; color: #ffffff; text-align: center; padding: 8px;'>Tanggal</th>";
$html .= "<th style='background-color: #2b5f9e; color: #ffffff; text-align: left; padding: 8px;'>Nama Obat</th>";
$html .= "<th style='background-color: #2b5f9e; color: #ffffff; text-align: center; padding: 8px;'>Jumlah</th>";
$html .= "<th style='background-color: #2b5f9e; color: #ffffff; text-align: right; padding: 8px;'>Harga Satuan (Rp)</th>";
$html .= "<th style='background-color: #2b5f9e; color: #ffffff; text-align: right; padding: 8px;'>Subtotal (Rp)</th>";
$html .= "<th style='background-color: #2b5f9e; color: #ffffff; text-align: right; padding: 8px;'>Total Nota (Rp)</th>";
$html .= "</tr>";

while ($row = mysqli_fetch_assoc($query)) {
    $is_new_nota = ($current_nota !== $row['no_nota']);
    
    if ($is_new_nota) {
        $current_nota = $row['no_nota'];
        $total_keseluruhan += $row['total_harga'];
        $total_transaksi++;
        $display_no = $no++;
        $display_nota = $row['no_nota'];
        $display_tgl = date('d/m/Y', strtotime($row['tgl_penjualan']));
        $display_total_nota = number_format($row['total_harga'], 0, ',', '.');
    } else {
        $display_no = "";
        $display_nota = "";
        $display_tgl = "";
        $display_total_nota = "";
    }
    
    $total_jumlah += $row['jumlah_beli'];

    $html .= "<tr>";
    $html .= "<td style='text-align: center; padding: 5px;'>" . $display_no . "</td>";
    $html .= "<td style='text-align: center; padding: 5px;'>" . $display_nota . "</td>";
    $html .= "<td style='text-align: center; padding: 5px;'>" . $display_tgl . "</td>";
    $html .= "<td style='text-align: left; padding: 5px;'>" . $row['nama_obat'] . "</td>";
    $html .= "<td style='text-align: center; padding: 5px;'>" . $row['jumlah_beli'] . "</td>";
    $html .= "<td style='text-align: right; padding: 5px;'>" . number_format($row['harga_jual'], 0, ',', '.') . "</td>";
    $html .= "<td style='text-align: right; padding: 5px;'>" . number_format($row['subtotal'], 0, ',', '.') . "</td>";
    $html .= "<td style='text-align: right; padding: 5px;'>" . $display_total_nota . "</td>";
    $html .= "</tr>";
}

// Footer row 1: Total Keseluruhan
$html .= "<tr>";
$html .= "<td colspan='4' style='text-align: right; font-weight: bold; color: #003399; background-color: #f0f8ff; padding: 8px;'>TOTAL KESELURUHAN</td>";
$html .= "<td style='text-align: center; font-weight: bold; color: #003399; background-color: #f0f8ff; padding: 8px;'>" . $total_jumlah . "</td>";
$html .= "<td style='background-color: #f0f8ff;'></td>";
$html .= "<td style='background-color: #f0f8ff;'></td>";
$html .= "<td style='text-align: right; font-weight: bold; color: #003399; background-color: #f0f8ff; padding: 8px;'>" . number_format($total_keseluruhan, 0, ',', '.') . "</td>";
$html .= "</tr>";

// Footer row 2: Total Transaksi
$html .= "<tr>";
$html .= "<td colspan='4' style='text-align: right; font-weight: bold; color: #003399; background-color: #e6f2ff; padding: 8px;'>Total Transaksi (Nota)</td>";
$html .= "<td style='text-align: center; font-weight: bold; color: #003399; background-color: #e6f2ff; padding: 8px;'>" . $total_transaksi . "</td>";
$html .= "<td colspan='3' style='background-color: #e6f2ff;'></td>";
$html .= "</tr>";

$html .= "</table>";
echo $html;
?>
