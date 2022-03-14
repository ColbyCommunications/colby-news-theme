import globalAlert from '../twig/global-alert.twig';
import Icon from './Icon';

const GlobalAlert = (args) => {
  // 'w-8 h-8'
  const icon = Icon({
    icon: 'interface-exclamation-triangle',
    size: '8',
    title: 'Alert',
  });
  return globalAlert({ ...args, icon });
};

export default GlobalAlert;
