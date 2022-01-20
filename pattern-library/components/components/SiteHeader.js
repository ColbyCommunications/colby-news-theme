import siteHeaderTemplate from '../twig/site-header.twig';
import siteHeaderMarkup from '../twig/site-header-markup.twig';
import modalTemplate from '../twig/modal.twig';
import mainMenuContentTemplate from '../twig/main-menu-content.twig';
import siteSearchTemplate from '../twig/site-search.twig';
import GlobalAlert from './GlobalAlert';

const realSiteHeader = siteHeaderMarkup({ isRealHeader: true });
const modalSiteHeader = siteHeaderMarkup({ isRealHeader: false });

const SiteHeader = (args) => {
  const globalAlert = args.globalAlert ? GlobalAlert(args.globalAlert) : '';

  const menuModal = modalTemplate({
    ...args, // includes `modalSiteFooter`, which is identical to "real" site-footer
    modalId: 'main-menu',
    modalLabel: 'Main menu',
    closeButtonId: 'close-menu',
    modalContent: mainMenuContentTemplate({ ...args }),
    modalSiteHeader,
  });

  const searchModal = modalTemplate({
    ...args, // includes `modalSiteFooter`, which is identical to "real" site-footer
    modalId: 'site-search',
    modalLabel: 'Site search',
    closeButtonId: 'close-search',
    modalContent: siteSearchTemplate(),
    modalSiteHeader,
  });

  return siteHeaderTemplate({
    ...args,
    realSiteHeader,
    globalAlert,
    menuModal,
    searchModal,
  });
};

export default SiteHeader;
