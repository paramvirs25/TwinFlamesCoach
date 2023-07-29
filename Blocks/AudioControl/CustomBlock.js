(function() {
    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var __ = wp.i18n.__;
  
    registerBlockType('custom/hindi-contentbox', {
      title: __('Hindi Content Box'),
      icon: 'admin-customizer',
      category: 'common',
  
      edit: function() {
        return el(
          'div',
          { className: 'wp-block-group contentbox' },
          el(
            'h5',
            { className: 'wp-block-heading' },
            __('Hindi')
          ),
          el(
            'figure',
            { className: 'wp-block-audio' },
            el(
              'audio',
              { controls: true, src: 'https://docs.google.com/uc?export=open&id=1iP2_gg_3BX92aiDvPAqfMnzCEYxkdphb' }
            )
          ),
          el(
            'p',
            { className: 'has-text-align-center' },
            el(
              'a',
              {
                className: 'dropbox-saver',
                'data-filename': '1.1 Connection Tool (Hindi).mp3',
                href: 'https://docs.google.com/uc?export=download&id=1iP2_gg_3BX92aiDvPAqfMnzCEYxkdphb'
              },
              __('Save to Dropbox')
            )
          )
        );
      },
  
      save: function() {
        return el(
          'div',
          { className: 'wp-block-group contentbox' },
          el(
            'h5',
            { className: 'wp-block-heading' },
            __('Hindi')
          ),
          el(
            'figure',
            { className: 'wp-block-audio' },
            el(
              'audio',
              { controls: true, src: 'https://docs.google.com/uc?export=open&id=1iP2_gg_3BX92aiDvPAqfMnzCEYxkdphb' }
            )
          ),
          el(
            'p',
            { className: 'has-text-align-center' },
            el(
              'a',
              {
                className: 'dropbox-saver',
                'data-filename': '1.1 Connection Tool (Hindi).mp3',
                href: 'https://docs.google.com/uc?export=download&id=1iP2_gg_3BX92aiDvPAqfMnzCEYxkdphb'
              },
              __('Save to Dropbox')
            )
          )
        );
      },
    });
  })();
  