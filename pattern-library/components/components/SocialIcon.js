import Icon from './Icon';

const socialIconDetails = [
  {
    url: 'facebook.com',
    icon: 'social-facebook',
    label: 'Facebook',
  },
  {
    url: 'twitter.com',
    icon: 'social-twitter',
    label: 'Twitter',
  },
  {
    url: 'linkedin.com',
    icon: 'social-linkedin',
    label: 'LinkedIn',
  },
  {
    url: 'snapchat.com',
    icon: 'social-snapchat',
    label: 'Snapchat',
  },
  {
    url: 'instagram.com',
    icon: 'social-instagram',
    label: 'Instagram',
  },
  {
    url: 'youtube.com',
    icon: 'social-youtube',
    label: 'YouTube',
  },
  {
    url: 'vimeo.com',
    icon: 'social-vimeo',
    label: 'Vimeo',
  },
  {
    url: 'flickr.com',
    icon: 'social-flickr',
    label: 'Flickr',
  },
];

const getIconDetails = (url) => {
  for (let i = 0; i < socialIconDetails.length; i += 1) {
    if (url.includes(socialIconDetails[i].url)) {
      return socialIconDetails[i];
    }
  }

  return false;
};

const SocialIcon = ({ url, title, width = 5, height = 5 }) => {
  const iconDetails = getIconDetails(url);

  if (!iconDetails) {
    return false;
  }

  const args = {
    width: width ?? 20,
    height: height ?? 20,
    icon: iconDetails.icon,
    hiddenText: title || iconDetails.label,
  };
  return Icon(args);
};

export default SocialIcon;
