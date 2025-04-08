export default function shareButton() {
  const shareButtonWrappers = document.querySelectorAll('.post-share-button-wrapper');
  const copyLinkButton = document.querySelector('.post-share-button.link-share');
  let clipboardCopied = false; //wether to insert the success text on link copy
  console.log(copyLinkButton);
  shareButtonWrappers.forEach(
    (element) => {
      element.querySelector('.post-share-button.main-share').addEventListener('click', (event) => {
        if (navigator.share && window.innerWidth < 900) {
          navigator.share({
            title: 'WebShare API Demo',
            url: 'https://codepen.io/ayoisaiah/pen/YbNazJ'
          }).then(() => {
            console.log('Thanks for sharing!');
          })
            .catch(console.error);
        } else {
          let dropdownMenu = event.target.parentNode.querySelector('.share-dropdown-menu');
          if (dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
          } else {
            dropdownMenu.classList.add('show');
          }
        }
      });
    }
  );
  copyLinkButton.addEventListener('click', (event) => {
     let link = event.target.value;
     let copiedSuccessText = event.target.getAttribute('data-copied-text');
     navigator.clipboard.writeText(link).then(() => {
      // Additional feedback to user can be added here
      if (!clipboardCopied){
        event.target.insertAdjacentHTML('afterend', '<span class="d-block text-success mt-2">' + copiedSuccessText + '</span>');
        clipboardCopied = true;
      }
    })
    .catch((error) => {
      console.error('Failed to copy text: ', error.message);
      // Provide feedback to the user about the error
    });;
  });
}
