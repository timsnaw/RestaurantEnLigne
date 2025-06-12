$(document).ready(function() {
    // gere comment form
    $('#add-comment-form').on('submit', function(e) {
        e.preventDefault();

       
        const submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true).text('Envoi en cours...');

        const formData = $(this).serialize();
        const platId = new URLSearchParams(window.location.search).get('plat_id');
        const url = `index.php?page=details&action=add_comment&plat_id=${platId}`;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Clear form
                    $('#add-comment-form')[0].reset();
                    $('#commentaire').val(''); 
                    $('.star-rating input[value="5"]').prop('checked', true);

                    // Create nouvelle comment HTML
                    const stars = response.comment.note > 0
                        ? Array(response.comment.note).fill('<i class="fas fa-star" style="font-size: 12px;"></i>')
                            .concat(Array(5 - response.comment.note).fill('<i class="far fa-star" style="font-size: 12px;"></i>'))
                            .join('')
                        : '<span class="text-muted">Aucune étoile</span>';

                    const commentHtml = `
                        <div class="comment-item border p-3 mb-3 rounded" data-avis-id="${response.comment.avis_id}">
                            <div class="d-flex align-items-center">
                                <img src="public/img/${response.comment.image_client || 'default_user.png'}" alt="User" class="rounded-circle" style="width: 40px; height: 40px;">
                                <div class="ms-3">
                                    <strong>${response.comment.prenom} ${response.comment.nom}</strong>
                                    <div class="text-warning">${stars}</div>
                                </div>
                            </div>
                            <p class="mt-2">${response.comment.commentaire}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">${new Date(response.comment.date_avis).toLocaleString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</small>
                                <form class="delete-comment-form" method="POST" action="index.php?page=details&action=delete_comment&plat_id=${platId}&avis_id=${response.comment.avis_id}">
                                    <input type="hidden" name="csrf_token" value="${$('#add-comment-form input[name="csrf_token"]').val()}">
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    `;

                    // ajouter nouveaux comment to the comments list
                    const $commentsList = $('#comments-list');
                    const $noComments = $commentsList.find('#no-comments');
                    if ($noComments.length) {
                        $noComments.remove(); // supprimer "No comments" message if present
                    }
                    $commentsList.prepend(commentHtml); // ajouter nouveaux comment dans le  top

                    // afficher success message
                    $('#alert-container').html('<div class="alert alert-success">Avis ajouté avec succès</div>');
                    setTimeout(() => $('#alert-container').empty(), 3000); // Clear alert after 3 seconds
                } else {
                    // afficher error message
                    $('#alert-container').html(`<div class="alert alert-danger">${response.message}</div>`);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                $('#alert-container').html('<div class="alert alert-danger">Erreur réseau: ' + error + '</div>');
            },
            complete: function() {
                submitButton.prop('disabled', false).text('Envoyer');
            }
        });
    });

    // gerer comment supprision
    $(document).on('submit', '.delete-comment-form', function(e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const formData = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // supprimer  comment from  DOM
                    form.closest('.comment-item').remove();

                    // afficher success message
                    $('#alert-container').html('<div class="alert alert-success">Avis supprimé avec succès</div>');
                    setTimeout(() => $('#alert-container').empty(), 3000);

                    // si no comments ajoute, afficher "No comments" message
                    if ($('#comments-list').children().length === 0) {
                        $('#comments-list').html('<p id="no-comments">Aucun avis pour ce plat pour le moment.</p>');
                    }
                } else {
                    $('#alert-container').html(`<div class="alert alert-danger">${response.message}</div>`);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                $('#alert-container').html('<div class="alert alert-danger">Erreur réseau: ' + error + '</div>');
            }
        });
    });
});