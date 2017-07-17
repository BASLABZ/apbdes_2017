# catatan

penulisan `kode-org` dan `kode-desa` menggunakan `lzero` (01, 05, dst).

kecuali `kode-bidang` (salah satunya di tabel `spp` tipe varchar),
penulisannya tidak menggunakan `lzero` malah harus `int`.
jadi, jika kode `01` maka diubah `1`.


# index

untuk standar penulisan kode, terutama penggunaan javascript. tekmen rodo angel nek nggo js neng ci.

---

# menggunakan jquery di module

```html
<!-- misal ini view home -->
<h1>Home</h1>

<div id="tabel">
	<?php echo $data ?>
	<!-- content dst -->
</div>

<!-- di akhir view, tulis: -->
<script>
winload(function() {
	$('#tabel').css('color','red');
});
</script>
```

jadi, __sebaiknya__ tak usah edit file `/application/views/layout.php`, kecuali js yg tiap halaman harus ada, seperti: logout.

---

# membuat file js untuk module

kalau elu mau nulis js di file beda, silahkan buat filenya di folder `/resource/config/`.

pertama, buat file `/resource/config/home-keren.js`, isinya:

```js
$('#tabel').css('color','red');

$('#button_ku').on('penyet',function() {
	alert('serius dihapus ?');
});
```
kemudian, di viewnya:

```html
<!-- view home -->
<h1>home</h1>

<div id="tabel">
	<button id="button_ku">hapus</button>
	<?php echo $data ?>
	<!-- content dst -->
</div>

<!-- di akhir view, tulis: -->
<script>
winload(function() {
	config('home-keren');
});
</script>
```

---

# menggunakan plugin templat pada view

web ini pakai templat `inspinia`. karo ms aan, diset foldere neng `/resource/themes/default/`.

jika pengen menggunakan pluginnya, __sebaiknya__ jangan tulis di file `/application/views/layout.php`.

misalnya, elu pengen pake `dataTables`, itu ada 2 file yg dipakai. yaitu:

`/resource/themes/default/js/plugins/dataTables/datatables.min.js`

`/resource/themes/default/css/plugins/dataTables/datatables.min.css`

di viewnya tinggal:

```html
<!-- view home -->
<h1>home</h1>

<div id="tabel">
	<!-- content dst -->
</div>

<!-- di akhir view, tulis: -->
<script>
winload(function() {

	// /resource/themes/default/css/plugins/[dataTables/datatables.min].css
	//                                       -------------------------
	// untuk css:
	plug('css','dataTables/datatables.min');

	// /resource/themes/default/css/plugins/[dataTables/datatables.min].css
	//                                      ---------------------------
	// untuk js:
	plug('js','dataTables/datatables.min');

	// karena kedua nama-parameternya sama, bisa langsung:
	plug('both','dataTables/datatables.min');

	$(document).ready(function() {
		$('#tabel').dataTables();
	});
});
</script>
```














