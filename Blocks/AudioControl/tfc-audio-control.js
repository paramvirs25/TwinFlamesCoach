(function() {
  var el = wp.element.createElement;
  var registerBlockType = wp.blocks.registerBlockType;
  var __ = wp.i18n.__;

  registerBlockType('custom/tfc-audio-control', {
    title: __('Tfc Audio Control'),
    icon: 'admin-customizer',
    category: 'common',

    attributes: {
      audio_file_language: {
        type: 'string',
        default: 'Hindi', // Default language if not set
      },
      audio_file_id: {
        type: 'string',
        default: '', // Default ID if not set
      },
      audio_file_name: {
        type: 'string',
        default: '', // Default filename if not set
      },
    },

    edit: function(props) {
      var { audio_file_language, audio_file_id, audio_file_name } = props.attributes;

      function onLanguageChange(newLanguage) {
        props.setAttributes({ audio_file_language: newLanguage });
      }

      function onFileIdChange(newFileId) {
        props.setAttributes({ audio_file_id: newFileId });
      }

      function onFileNameChange(newFileName) {
        props.setAttributes({ audio_file_name: newFileName });
      }

      return el(
        'div',
        { className: 'wp-block-group contentbox' },
        el(wp.blockEditor.InspectorControls, {}, // To display block settings in the sidebar
          el(wp.components.PanelBody, { title: __('Audio Settings') },
            el(wp.components.TextControl, {
              label: __('Audio Language'),
              value: audio_file_language,
              onChange: onLanguageChange,
              placeholder: __('Enter audio file language...'),
            }),
            el(wp.components.TextControl, {
              label: __('Audio ID'),
              value: audio_file_id,
              onChange: onFileIdChange,
              placeholder: __('Enter audio file ID...'),
            }),
            el(wp.components.TextControl, {
              label: __('Audio File Name'),
              value: audio_file_name,
              onChange: onFileNameChange,
              placeholder: __('Enter audio file name...'),
            })
          )
        ),
        el(
          'div', // Main content block
          null,
          el(
            'h5',
            { className: 'wp-block-heading' },
            audio_file_language
          ),
          el(
            'figure',
            { className: 'wp-block-audio' },
            el(
              'audio',
              { controls: true, src: 'https://docs.google.com/uc?export=open&id=' + audio_file_id }
            )
          ),
          el(
            'p',
            { className: 'has-text-align-center' },
            el(
              'a',
              {
                className: 'dropbox-saver',
                'data-filename': audio_file_name,
                href: 'https://docs.google.com/uc?export=download&id=' + audio_file_id
              },
              __('Save to Dropbox')
            )
          )
        )
      );
    },

    save: function(props) {
      var { audio_file_language, audio_file_id, audio_file_name } = props.attributes;

      return el(
        'div',
        { className: 'wp-block-group contentbox' },
        el(
          'h5',
          { className: 'wp-block-heading' },
          audio_file_language
        ),
        el(
          'figure',
          { className: 'wp-block-audio' },
          el(
            'audio',
            { controls: true, src: 'https://docs.google.com/uc?export=open&id=' + audio_file_id }
          )
        ),
        el(
          'p',
          { className: 'has-text-align-center' },
          el(
            'a',
            {
              className: 'dropbox-saver',
              'data-filename': audio_file_name,
              href: 'https://docs.google.com/uc?export=download&id=' + audio_file_id
            },
            __('Save to Dropbox')
          )
        )
      );
    },
  });
})();
