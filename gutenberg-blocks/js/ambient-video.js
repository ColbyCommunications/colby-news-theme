/*
 * Ambient video processing and initialization.
 */

const initAmbientVideo = () => {
  const $ = jQuery;

  const setButtonToPause = function setButtonToPause($buttonElement) {
    const icon = $buttonElement.data('pause-icon');
    $buttonElement.attr('aria-label', 'Pause background video');
    $buttonElement.find('.icon').html(icon);
  };

  const setButtonToPlay = function setButtonToPlay($buttonElement) {
    const icon = $buttonElement.data('play-icon');
    $buttonElement.attr('aria-label', 'Play background video');
    $buttonElement.find('.icon').html(icon);
  };

  const initVimeo = (args) => {
    const defaultArgs = {
      width: 2400,
      autoplay: true,
      autopause: true,
      controls: false,
      loop: true,
      muted: true,
    };

    const newArgs = { ...defaultArgs, ...args };

    if (!newArgs.url) {
      return;
    }

    const Player = new Vimeo.Player('ambientVideo', newArgs);

    return Player;
  };

  const loadPlayer = ({
    url = '',
    autoplay = true,
    $av = '',
    icons = {},
    iconPrefix = '',
    pauseCookieName = '',
  } = {}) => {
    const Player = initVimeo({
      url,
      autoplay,
    });

    Player.on('loaded', function () {
      const $control = addPlayButton(
        $av.parent().parent(),
        'pause',
        icons,
        iconPrefix
      );
      if (!autoplay) {
        setButtonToPlay($control);
      } else {
        Cookies.set(pauseCookieName, false);
        setButtonToPause($control);
      }
      $control.on('click', function (e) {
        const $button = jQuery(e.currentTarget);
        $button.toggleClass('video-button--paused');
        Player.getPaused().then(function (paused) {
          if (paused) {
            Cookies.set(pauseCookieName, false);
            autoplay = true;
            Player.play();
            setButtonToPause($button);
          } else {
            Cookies.set(pauseCookieName, true);
            Player.pause();
            setButtonToPlay($button);

            // Hook into the Vimeo Player API to make data available to Google Tag Manager
            Player.getCurrentTime().then(function (seconds) {
              let message = void 0;
              if (seconds < 2) {
                message = 'quickly (less than 2 seconds)';
              } else if (seconds >= 2 && seconds <= 5) {
                message = 'moderately (between 2 and 5 seconds)';
              } else {
                message = 'slowly (more than 5 seconds)';
              }

              window.dataLayer = window.dataLayer || [];
              window.dataLayer.push({
                event: 'pause_ambient_video',
                elapsed: message,
              });
            });
          }
        });
      });
    });
  };

  const iconMarkup = (iconName, iconPrefix = '') =>
    `<svg class="icon w-10 h-10 fill-current"><use xlink:href="${iconPrefix}#${iconName}"></use></svg>`;

  const addPlayButton = (
    $parent,
    state = 'pause',
    iconNames,
    iconPrefix = ''
  ) => {
    const button = $('<button />');
    const icon = $('<div />');
    const icons = {};

    if (iconNames.play) {
      icons.play = iconMarkup(iconNames.play, iconPrefix);
    }
    if (iconNames.pause) {
      icons.pause = iconMarkup(iconNames.pause, iconPrefix);
    }

    button.data('play-icon', icons.play);
    button.data('pause-icon', icons.pause);
    button.addClass([
      'block',
      'absolute',
      'z-10',
      'top-0',
      'w-full',
      'h-full',
      'text-white',
      'text-xl',
      'font-bold',
    ]);
    icon.addClass([
      'icon',
      'flex-none',
      'rounded-full',
      'bg-primary',
      'hocus:bg-tertiary-dark',
      'text-white',
      'transition-colors',
    ]);
    icon.html(icons[state]);

    const iconWrapper = $('<div />');

    iconWrapper.addClass([
      'flex',
      'items-end',
      'justify-end',
      'h-full',
      'container',
      'mx-auto',
      'px-container',
      'py-10',
    ]);
    iconWrapper.html(icon);

    button.html(iconWrapper);

    $parent.append(button);

    return button;
  };

  const ambient_video = function ambient_video() {
    const $av = jQuery('#ambientVideo');
    if ($av.length <= 0) return;
    const url = $av.data('url');
    const icons = {
      play: $av.data('play-icon'),
      pause: $av.data('pause-icon'),
    };
    const iconPrefix = $av.data('icon-file');

    const pauseCookieName = 'uncSoePauseAmbientVideo';
    let pauseCookie = false;

    if (typeof Cookies !== 'undefined' && typeof Cookies.get === 'function') {
      pauseCookie = !(
        !Cookies.get(pauseCookieName) ||
        Cookies.get(pauseCookieName) === 'false'
      );
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)')
      .matches;

    if (reducedMotion) {
      console.warn(
        'Video will not autoplay because the user has enabled the "Reduce Motion" setting on their browser or OS.'
      );
    }

    let autoplay = 1;
    if (
      pauseCookie ||
      window.matchMedia('(prefers-reduced-motion: reduce)').matches
    ) {
      autoplay = 0;
    }

    const playerArgs = {
      url: url,
      autoplay: autoplay,
      $av: $av,
      icons: icons,
      iconPrefix: iconPrefix,
      pauseCookieName: pauseCookieName,
    };

    if (autoplay) {
      loadPlayer(playerArgs);
    } else {
      playerArgs.autoplay = true;

      const $launcherButton = addPlayButton(
        $av.parent().parent(),
        'play',
        icons,
        iconPrefix
      );

      $launcherButton.click(() => {
        loadPlayer(playerArgs);
      });
    }
  };

  ambient_video();
};

initAmbientVideo();
