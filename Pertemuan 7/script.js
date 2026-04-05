// Event Handler
// const tombol = document.getElementById('tombol');
// tombol.onclick = function() {
//     alert('Tombol sudah diklik');
// }

// const form = document.querySelector('form');
// form.addEventListener('submit', function(event) {
//     event.preventDefault();
//     const name = document.querySelector('input[name="name"]').value;
//     alert('Nama yang dimasukan: ' + name);
// })


// Manipulasi HTML
// function ubah() {
//     document.getElementById("judul").textContent = "Judul sudah diubah";
//     document.getElementById("paragraf").innerHTML = "Paragraf sudah diubah menggunakan <strong>innerHTML</strong>";
// }

// function ubahStyle() {
//     const element = document.getElementById("judul");
//     element.style.color = "red";
//     element.style.fontSize = "24px";
// }

function cekangka() {
    let x = document.getElementById("angka").value;
    let hasil;

    if (isNaN(x) || x < 1 || x > 10) {
        hasil = " Input tidak valid";
    } else {
        hasil = "Innput valid";
    }

    document.getElementById("hasil").textContent = hasil;
}