export default function shareButton() {
  const shareButtonWrappers = document.querySelectorAll('.post-share-button-wrapper');
  const copyLinkButton = document.querySelectorAll('.post-share-button.link-share');
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
     let copiedText = event.target.getAttribute('data-copied-text');
     navigator.clipboard.writeText('link');
  })

}
