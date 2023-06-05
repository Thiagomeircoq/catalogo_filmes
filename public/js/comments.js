$('.add-comment').on('click', () => createStructure() )

function createStructure() {
    const overlay = $('<div>').attr('class', 'overlay').appendTo('body');
    const commentsDiv = $('<div>').attr('class', 'commentsDiv').appendTo(overlay);
    const commentsHeader = $('<div>').attr('class', 'commentsHeader').appendTo(commentsDiv);
    const headerText = $('<h2>', { class: 'headerText', text: 'Criar Publicação' }).appendTo(commentsHeader);
    const commentsIcon = $('<i>').attr('class', 'fa-sharp fa-solid fa-circle-xmark').appendTo(commentsHeader);
    const textDiv = $('<div>').attr('class', 'textDiv').appendTo(commentsDiv);
    const titleComment = $('<input>').attr('class', 'input').attr('placeholder', 'Titulo do comentario...').appendTo(textDiv);
    const textArea = $('<textarea>').attr('class', 'textarea').attr('placeholder', 'Digite aqui...').appendTo(textDiv);
  
    commentsIcon.on('click', () => {
      overlay.remove();
    });
  
    textArea.on('input', () => {
      let text = textArea.val();
      if (text.length > 700) {
        text = text.substr(0, 255);
        textArea.val(text);
      }
      const remainingChars = 700 - text.length;
      const counter = `${remainingChars}/700`;
      $('#charCounter').text(counter);
    });
  
    const counterText = $('<div>').attr('id', 'charCounter').text('700/700').appendTo(textDiv);
    const recommendMovie = $('<div>').attr('class', 'recommendMovie').appendTo(textDiv);
  
    const recommendLabel = $('<label>').addClass('radio-label').text('Recomendar').appendTo(recommendMovie);
    const recommendInput = $('<input>').attr('type', 'radio').attr('name', 'recommend').attr('value', 'recomendar').attr('checked', true).appendTo(recommendLabel).addClass('radio');

    const notRecommendLabel = $('<label>').addClass('radio-label').text('Não Recomendar').appendTo(recommendMovie);
    const notRecommendInput = $('<input>').attr('type', 'radio').attr('name', 'recommend').attr('value', 'nao_recomendar').appendTo(notRecommendLabel).addClass('radio');
  
    const commentsFooter = $('<div>').attr('class', 'commentsButton').appendTo(commentsDiv);
    const button = $('<button>').attr('class', 'btn').text('Publicar').appendTo(commentsFooter);

    button.on('click', () => {
        const tituloComment = titleComment.val();
        const comment = textArea.val();
        const recommend = $('input[name="recommend"]:checked').val();
        if (tituloComment.length != "" && comment != "") {
            addComment(tituloComment, comment, recommend);
        }
    });

}

function addComment(tituloComment, comment, recommend) {
    $.ajax({
        url: `/comment/add/${idMovie}/${encodeURIComponent(tituloComment)}/${encodeURIComponent(comment)}/${encodeURIComponent(recommend)}`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            tituloComment: tituloComment,
            comment: comment,
            recommend: recommend
        },
        success: function (data) {
            createStructureComments();
            $('.overlay').remove();
        },
        error: function (error) {
            console.error(error);
        }
    });
}

async function createStructureComments() {
    const commentsData = await getComments();
    $('.comments-list').empty();

    commentsData.forEach(comment => {
        const commentDiv = $('<div>').attr('class', 'comment').appendTo('.comments-list');
        const userRatingsDiv = $('<div>').attr('class', 'user-ratings').appendTo(commentDiv);
        const infosUserDiv = $('<div>').attr('class', 'infos-user').appendTo(userRatingsDiv);
        const avatarDiv = $('<div>').attr('class', 'avatar').appendTo(infosUserDiv);
        const avatarUser = $('<p>').attr('class', 'avatar-user').text(comment.user.name.charAt(0).toUpperCase()).appendTo(avatarDiv);
        const userInfoDiv = $('<div>').attr('class', '').appendTo(infosUserDiv);
        const userName = $('<p>').attr('class', 'user-name').text(comment.user.name).appendTo(userInfoDiv);
        const infosRatingsDiv = $('<div>').attr('class', 'infos-ratings').appendTo(userRatingsDiv);

        const feedbackUserDiv = $('<div>').attr('class', 'feddback-user').appendTo(infosRatingsDiv);
        const likeDeslikeDiv = $('<div>').attr('class', 'like-deslike').appendTo(feedbackUserDiv);
        const thumbsUpIcon = $('<i>').attr('class', 'fa-solid').appendTo(likeDeslikeDiv);
        const recommendDiv = $('<div>').appendTo(feedbackUserDiv);
        const recommendText = $('<p>').appendTo(recommendDiv);
        
        if (comment.recomendado == "recomendar") {
            likeDeslikeDiv.toggleClass('like');
            thumbsUpIcon.toggleClass('fa-thumbs-up');
            recommendText.text('Recomendado');
        } else {
            likeDeslikeDiv.toggleClass('deslike');
            thumbsUpIcon.toggleClass('fa-thumbs-down');
            recommendText.text('Não Recomendado');
        }

        const commentsUserDiv = $('<div>').attr('class', 'comments-user').appendTo(infosRatingsDiv);
        const commentTitle = $('<h2>').text(comment.titulo).appendTo(commentsUserDiv);
        const commentText = $('<p>').text(comment.comentario).appendTo(commentsUserDiv);
    });
}

createStructureComments();

async function getComments() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "/comment/list/" + idMovie,
            method: 'GET',
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}