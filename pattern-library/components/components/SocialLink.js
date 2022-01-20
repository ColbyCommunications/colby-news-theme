import SocialIcon from './SocialIcon';

const SocialLink = (args) => {
  return `<a href="${args.url}" class="block social-link focus:outline-white">
                <div class="social-icon transition transition-colors rounded-full p-2">${SocialIcon(
                  { ...args }
                )}</div>
            </a>`;
};

export default SocialLink;
