const idMovie = $('.btn').attr('id');

function movieIsFavorite() {
  
    $.ajax({
        url: "/favorite/" + idMovie,
        method: 'GET',
        success: function (data) {
            if (data.isFavorite) {
                $('#button-favorite').attr('title', 'Desfavoritar');
                $('#iconFavorito').attr('class', 'fa-solid fa-heart')
            } else {
                $('#button-favorite').attr('title', 'Favoritar');
                $('#iconFavorito').attr('class', 'fa-regular fa-heart')
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}

movieIsFavorite();

$('#button-favorite').on('click', () => {
    let acao;
    if ($('#button-favorite').attr('title') == 'Favoritar') {
        acao = 'add';
    } else {
        acao = 'remove';
    }
    $.ajax({
        url: `/favorites/${acao}/${idMovie}`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function (data) {
            movieIsFavorite();
        },
        error: function (error) {
            console.error(error);
        }
    })
})