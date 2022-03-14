import siteFooterTemplate from '../twig/site-footer.twig';
import SocialLink from './SocialLink';

const SiteFooter = (args) => {
  let socialLinks = [];

  if (Array.isArray(args.socialLinks)) {
    socialLinks = args.socialLinks.map((link) => {
      const socialIcon = SocialLink({ url: link.url, title: link.title });
      const socialLinkContent = socialIcon || link.title;

      return socialLinkContent;
    });
  }

  const footer = siteFooterTemplate({
    ...args,
    socialLinks,
  });
  return footer;
};

export default SiteFooter;
