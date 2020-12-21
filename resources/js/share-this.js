export default () => {
  const copyBtn = document.querySelector('#copy');

  if (navigator.clipboard) {
    copyBtn.addEventListener('click', (e) => {
      e.preventDefault();
      navigator.clipboard.writeText(location.href);
    });
  } else {
    copyBtn.classList.add('share-this__link--is-disabled');
  }
};
