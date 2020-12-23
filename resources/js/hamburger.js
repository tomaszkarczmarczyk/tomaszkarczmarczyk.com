import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock';

export default () => {
  const btn = document.querySelector('#hamburger');
  const aside = document.querySelector('#aside');
  const visibleCLass = 'aside--is-visible';

  btn.addEventListener('click', (e) => {
    e.currentTarget.classList.toggle('hamburger--is-open');
    aside.classList.toggle(visibleCLass);
    aside.classList.contains(visibleCLass)
      ? disableBodyScroll(aside, { reserveScrollBarGap: true })
      : enableBodyScroll(aside);
  });
};
