const API_KEY = '285d3a107fb634471d88c967759b0197';

document.addEventListener("DOMContentLoaded", function() {
  var movieSwipers = document.querySelectorAll(".movies-swiper");
  movieSwipers.forEach(function(swiperContainer) {
    let swiper = new Swiper(swiperContainer, {
      loop: true,
      slidesPerView: getSlidesPerView(),
      spaceBetween: 25,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });

    function getSlidesPerView() {
      if (window.innerWidth <= 865) {
        return Math.min(1, movieSwipers.length);
      } else if (window.innerWidth <= 600) {
        return Math.min(2, movieSwipers.length);
      } else if (window.innerWidth <= 500) {
        return Math.min(1, movieSwipers.length);
      } else {
        return Math.min(6, movieSwipers.length);
      }
    }

    window.addEventListener('resize', function() {
      swiper.params.slidesPerView = getSlidesPerView();
      swiper.update();
    });
  });
});


const trailerPoster = document.querySelector('.trailer-poster');
if (trailerPoster) {
  trailerPoster.addEventListener('click', playTrailer)
}

const btn = document.querySelector('.btn');
if (btn) {
  btn.addEventListener('click', playTrailer);
}

async function playTrailer() {
  try {
    const trailerKey = await getTrailerKey(btn.id, 'pt-BR');
    if (!trailerKey) {
      const fallbackTrailerKey = await getTrailerKey(btn.id, 'en-US');
      if (!fallbackTrailerKey) {
        alert('Trailer indisponível!');
        return;
      }
      viewMovie(fallbackTrailerKey);
    } else {
      viewMovie(trailerKey);
    }
  } catch (error) {
    console.error(error);
  }
}

async function getTrailerKey(movieId, language) {
  const url = `https://api.themoviedb.org/3/movie/${movieId}/videos?api_key=${API_KEY}&language=${language}`;
  const response = await fetch(url);
  if (response.ok) {
    const data = await response.json();
    const trailers = data.results.filter(obj => obj.type === 'Trailer');
    if (trailers.length > 0) {
      const lastTrailer = trailers[trailers.length - 1];
      return lastTrailer.key;
    }
  }
  return null;
}

async function viewMovie(movieKey) {
  const videoId = movieKey;

  const overlay = document.createElement('div');
  overlay.classList.add('overlay');

  const iframe = document.createElement('iframe');
  iframe.src = `https://www.youtube.com/embed/${videoId}`;
  iframe.classList.add('movie-trailer');
  iframe.allowFullscreen = true;

  const body = document.getElementsByTagName('body')[0];
  body.appendChild(overlay);
  overlay.appendChild(iframe);

  overlay.addEventListener('click', () => {
    overlay.remove();
  })
}

var usuarioClicou = true;

function toggleInput() {
  let largura = $(window).width();

  if (largura <= 500) {
    if (usuarioClicou) {
      $('.nav-item').css('display', 'none');
      $('.hamburger').css('display', 'none');
      $('#search').removeClass("hidden");
      $('.navbar').css('padding', '30px 0');
      $('#search').css('width', '100%');
      $('.navbar-nav').css('width', '100%');
      $('.navbar-nav li').css('width', '100%');
      usuarioClicou = false;
    } else {
      $('.nav-item').css('display', 'block');
      $('.hamburger').css('display', 'block');
      $('#search').addClass("hidden");
      $('.navbar').css('padding', '30px 50px');
      $('#search').css('width', '320px');
      $('.navbar-nav').css('width', 'auto');
      $('.navbar-nav li').css('width', 'auto');
      $('.search-movies').css('display', 'none');
      usuarioClicou = true;
    }
  } else {
    var searchInput = document.getElementById("search");
    searchInput.classList.toggle("hidden");
    $('.search-movies').css('display', 'none');
  }
}

var menuOn = true;

function showMenu() {
  let largura = $(window).width();

  if (largura <= 750) {
    if (menuOn) {
      $('#search-li').css('display', 'none');
      $('#categorias-list').css('display', 'flex').css('width', '100%');
      menuOn = false;
    } else {
      $('#search-li').css('display', 'flex');
      $('#categorias-list').css('display', 'none');
      menuOn = true;
    }
  } else {
    $('#search-li').css('display', 'flex');
    $('#categorias-list').css('display', 'flex').css('width', 'auto');
    menuOn = true;
  }
}

let timerId;
const searchInput = document.querySelector('#search');
searchInput.addEventListener('input', () => {
  if (searchInput.value) {
    clearTimeout(timerId);
    timerId = setTimeout(() => {
      searchMovie(searchInput.value);
    }, 1000);
  } else {
    const moviesList = document.querySelector('.search-movies');
    moviesList.innerHTML = '';
    moviesList.style.display = 'none';
  }
});

async function searchMovie(search) {
  const url = `https://api.themoviedb.org/3/search/movie?api_key=${API_KEY}&query=${search}&language=pt-BR`;
  const response = await fetch(url);
  if (response.ok) {
    const data = await response.json();
    if (data.results.length > 0) {
      return listFoundMovies(data, search);
    } else {
      const moviesList = document.querySelector('.search-movies');
      moviesList.innerHTML = '';
      moviesList.style.display = 'flex';
      const aviso = document.createElement('p');
      aviso.innerText = 'Ops, nenhum resultado foi encontrado.';
      moviesList.appendChild(aviso);
    }
  }
  return null;
}

async function listFoundMovies(movieData, search) {
  const moviesList = document.querySelector('.search-movies');
  moviesList.innerHTML = '';
  moviesList.style.display = 'flex';

  // console.log(movieData);

  const moviesToShow = movieData.results.filter(movie => movie.popularity > 40.000).slice(0, 8);

  if (moviesToShow.length > 0) {
    // console.log(moviesToShow);
    moviesToShow.forEach(movie => {
      const movieItem = document.createElement('a');
      const divImg = document.createElement('div');
      const img = document.createElement('img');
      const infosMovie = document.createElement('div');
      const titleMovie = document.createElement('h4');
      const voteAverage = document.createElement('p');
  
  
      img.src = `https://image.tmdb.org/t/p/original${movie.poster_path}`;
      img.width = '50';
      
      titleMovie.innerText = movie.title;
      voteAverage.innerText = parseFloat(movie.vote_average).toFixed(1);
      
      divImg.classList.add('img-movie');
      infosMovie.classList.add('infos-movie');
      voteAverage.classList.add('average');
      movieItem.href = `http://127.0.0.1:8000/movies/movie/${movie.id}`;
  
      moviesList.appendChild(movieItem);
      movieItem.appendChild(divImg);
      divImg.appendChild(img);
      movieItem.appendChild(infosMovie);
      infosMovie.appendChild(titleMovie);
      infosMovie.appendChild(voteAverage);
    });

    if (movieData.results.length > 8) {
      const moreMovies = movieData.results.filter(movie => movie.popularity > 30.000);
      const more = document.createElement('a');
      const moreText = document.createElement('p');
      const iconPlus = document.createElement('i');

      iconPlus.classList.add('fa-solid', 'fa-plus');
      moreText.innerText = 'ver todos';
      more.classList.add('more-info');

      more.addEventListener('click', function() {
        document.querySelector('form').submit();
      });

      moviesList.appendChild(more);
      more.appendChild(iconPlus);
      more.appendChild(moreText);
    }
  } else {
    const aviso = document.createElement('p');
    aviso.innerText = 'Ops, nenhum resultado foi encontrado.';
    moviesList.appendChild(aviso);
  }
}