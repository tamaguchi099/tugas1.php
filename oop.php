<?php

interface MetodePembayaran
{
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

class TransferBank implements MetodePembayaran
{
    private string $nomorRekening;

    public function __construct(string $nomorRekening)
    {
        $this->nomorRekening = $nomorRekening;
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $admin = 0;
        $total = $jumlah + $admin;

        echo "\n=== TRANSFER BANK ===\n";
        echo "Nomor Rekening : " . $this->nomorRekening . "\n";
        echo "Keterangan     : " . $keterangan . "\n";
        echo "Jumlah         : " . $this->rupiah($jumlah) . "\n";
        echo "Biaya Admin    : " . $this->rupiah($admin) . "\n";
        echo "Total Bayar    : " . $this->rupiah($total) . "\n";

        return true;
    }

    public function getNamaMetode(): string
    {
        return "Transfer Bank";
    }

    private function rupiah(float $jumlah): string
    {
        return "Rp " . number_format($jumlah, 0, ',', '.');
    }
}

class QRIS implements MetodePembayaran
{
    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $admin = $jumlah * 0.007;
        $total = $jumlah + $admin;

        echo "\n=== QRIS ===\n";
        echo "Keterangan     : " . $keterangan . "\n";
        echo "Jumlah         : " . $this->rupiah($jumlah) . "\n";
        echo "Biaya Admin    : " . $this->rupiah($admin) . "\n";
        echo "Total Bayar    : " . $this->rupiah($total) . "\n";

        return true;
    }

    public function getNamaMetode(): string
    {
        return "QRIS";
    }

    private function rupiah(float $jumlah): string
    {
        return "Rp " . number_format($jumlah, 0, ',', '.');
    }
}

class KartuKredit implements MetodePembayaran
{
    private string $nomorKartu;

    public function __construct(string $nomorKartu)
    {
        $this->nomorKartu = $nomorKartu;
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $admin = $jumlah * 0.025;
        $total = $jumlah + $admin;
        $digitTerakhir = substr($this->nomorKartu, -4);

        echo "\n=== KARTU KREDIT ===\n";
        echo "Nomor Kartu    : **** **** **** " . $digitTerakhir . "\n";
        echo "Keterangan     : " . $keterangan . "\n";
        echo "Jumlah         : " . $this->rupiah($jumlah) . "\n";
        echo "Biaya Admin    : " . $this->rupiah($admin) . "\n";
        echo "Total Bayar    : " . $this->rupiah($total) . "\n";

        return true;
    }

    public function getNamaMetode(): string
    {
        return "Kartu Kredit";
    }

    private function rupiah(float $jumlah): string
    {
        return "Rp " . number_format($jumlah, 0, ',', '.');
    }
}

interface Notifikasi
{
    public function kirim(): void;
}

class Email implements Notifikasi
{
    public function kirim(): void
    {
        echo "Notifikasi dikirim melalui Email.\n";
    }
}

class WhatsApp implements Notifikasi
{
    public function kirim(): void
    {
        echo "Notifikasi dikirim melalui WhatsApp.\n";
    }
}

class SMS implements Notifikasi
{
    public function kirim(): void
    {
        echo "Notifikasi dikirim melalui SMS.\n";
    }
}

// Menjalankan pembayaran
$transfer = new TransferBank("1234567890");
$qris = new QRIS();
$kartu = new KartuKredit("1234567812345678");

$metodePembayaran = [$transfer, $qris, $kartu];

echo "================================\n";
echo "       SISTEM PEMBAYARAN       \n";
echo "================================\n";

foreach ($metodePembayaran as $metode) {
    echo "\nMetode: " . $metode->getNamaMetode() . "\n";
    $metode->prosesBayar(500000, "Pembayaran barang");
    echo "--------------------------------\n";
}

// Menjalankan notifikasi
$notifikasi = [
    new Email(),
    new WhatsApp(),
    new SMS()
];

echo "\n================================\n";
echo "      NOTIFIKASI PEMBAYARAN     \n";
echo "================================\n";

foreach ($notifikasi as $saluran) {
    $saluran->kirim();
}

?>