// Like Picture function

let likePictureButtons = document.getElementsByClassName('likePictureButton');

for (let i = 0; i < likePictureButtons.length; i++) {
    likePictureButtons[i].addEventListener('click', addToLikeListPicture);
}

function addToLikeListPicture(e) {
    e.preventDefault();
    const likeListLink = e.currentTarget;
    const link = likeListLink.href;
    // Send an HTTP request with fetch to the URI defined in the href
    try {
        fetch(link)
            .then(res => res.json())
            .then(data => {
                const likelistIcon = likeListLink.firstElementChild;
                if (data.isInLikeListPicture) {
                    likelistIcon.classList.remove("bi-heart"); // Remove the .bi-heart (empty heart) from classes in <i> element
                    likelistIcon.classList.add("bi-heart-fill"); // Add the .bi-heart-fill (full heart) from classes in <i> element
                } else {
                    likelistIcon.classList.remove("bi-heart-fill"); // Remove the .bi-heart-fill (full heart) from classes in <i> element
                    likelistIcon.classList.add("bi-heart"); // Add the .bi-heart (empty heart) from classes in <i> element
                }
            });
    } catch (err) {
        console.error(err);
    }
}
