export default () => {
  const elements = document.querySelectorAll('.share-this__link--is-window');
  const copyBtn = document.querySelector('#copy');
  const width = 600;
  const height = 600;
  const top = window.top.outerHeight / 2 + window.top.screenY - height / 2;
  const left = window.top.outerWidth / 2 + window.top.screenX - width / 2;
  let windowObjectReference = null;
  let previousUrl = null;

  elements.forEach((el) => {
    el.addEventListener('click', (e) => {
      const url = e.currentTarget.getAttribute('href');

      e.preventDefault();

      if (windowObjectReference === null || windowObjectReference.closed) {
        windowObjectReference = window.open(
          url,
          'shareThisWindow',
          `resizable,scrollbars,status,width=${width},height=${height},left=${left},top=${top}`
        );
      } else if (previousUrl !== url) {
        windowObjectReference = window.open(
          url,
          'shareThisWindow',
          `resizable=yes,scrollbars=yes,status=yes,width=${width},height=${height},left=${left},top=${top}`
        );

        windowObjectReference.focus();
      } else {
        windowObjectReference.focus();
      }

      previousUrl = url;
    });
  });

  if (navigator.clipboard) {
    copyBtn.addEventListener('click', (e) => {
      e.preventDefault();
      navigator.clipboard.writeText(location.href);
    });
  } else {
    copyBtn.classList.add('share-this__link--is-disabled');
  }
};
