<?php


use App\Models\Layanan;
use App\Models\Pricelist;

beforeEach(fn () => $this->admin = buatAdmin());

test('admin bisa membuat paket dengan isi paket multi baris', function () {
    $layanan = Layanan::create(['nama_layanan' => 'Wedding', 'aktif' => true]);

    $this->actingAs($this->admin)->post(route('admin.layanan.store'), [
        'layanan_id'     => $layanan->id,
        'nama_pricelist' => 'Paket Gold',
        'deskripsi'      => 'Deskripsi',
        'harga'          => 2000000,
        'isi_paket'      => "Make up\nHair do\n\nSoftlens",
    ])->assertSessionHasNoErrors();

    expect(Pricelist::firstOrFail()->isi_paket)->toBe(['Make up', 'Hair do', 'Softlens']);
});

test('menghapus paket yang masih punya booking ditolak dengan pesan error', function () {
    $paket = buatPaket();
    buatBooking(['pricelist_id' => $paket->id]);

    $this->actingAs($this->admin)
        ->from(route('admin.layanan.index'))
        ->delete(route('admin.layanan.destroy', $paket))
        ->assertRedirect(route('admin.layanan.index'))
        ->assertSessionHasErrors('pricelist');

    expect($paket->fresh())->not->toBeNull();
});
