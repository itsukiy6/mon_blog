

document.addEventListener( 'DOMContentLoaded',  () => {
    new App();
     });

class App {
    constructor() {

        this.handleCommentForm();

    }




    handleCommentForm()
    {
        const commentForm = document.querySelector('form.comment-form');

        console.log(commentForm);

        if (null == commentForm) {
            return;
        }



        commentForm.addEventListener('submit', async(e) => {
            e.preventDefault();

            if (null == commentForm) {
                console.warn('Formulaire non trouvé.');
                return;
            }
            const response = await fetch('/ajax/comments', {
                method: 'POST',
                body: new FormData(e.target)
            })

            if (!response.ok) {
                return;
            }

            const json = await response.json();

            if (json.code === 'COMMENT_ADDED_SUCCESSFULLY') {
                const commentList = document.querySelector('.comment-list');
                const commentCount = document.querySelector('.comment-count');
                const commentContenu = document.querySelector('.comment-contenu');

                commentList.insertAdjacentHTML('beforeend', json.message);
                commentList.lastElementChild.scrollIntoView();

                commentCount.innerText = json.numberOfComments;

                commentContenu.value = '';
            }
        });
    }
}
