(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var __ = wp.i18n.__;
    var el = wp.element.createElement;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var TextControl = wp.components.TextControl;

    registerBlockType('tfc-audio-control/block', {
        title: __('Tfc Audio Control', 'tfc-audio-control'),
        icon: 'format-audio',
        category: 'common',
        attributes: {
            audio_file_language: {
                type: 'string',
                default: '',
            },
            audio_file_id: {
                type: 'string',
                default: '',
            },
            audio_file_name: {
                type: 'string',
                default: '',
            },
        },
        edit: function (props) {
            var attributes = props.attributes;
    
            return [
                el(InspectorControls, {
                    key: 'inspector'
                }, el('div', {
                    style: {
                        padding: '20px'
                    }
                }, el(TextControl, {
                    label: __('Audio File Language', 'tfc-audio-control'),
                    value: attributes.audio_file_language,
                    onChange: function (newValue) {
                        props.setAttributes({
                            audio_file_language: newValue
                        });
                    }
                }), el(TextControl, {
                    label: __('Audio File ID', 'tfc-audio-control'),
                    value: attributes.audio_file_id,
                    onChange: function (newValue) {
                        props.setAttributes({
                            audio_file_id: newValue
                        });
                    }
                }), el(TextControl, {
                    label: __('Audio File Name', 'tfc-audio-control'),
                    value: attributes.audio_file_name,
                    onChange: function (newValue) {
                        props.setAttributes({
                            audio_file_name: newValue
                        });
                    }
                }))),
                el('div', {
                    className: 'audio-language-display'
                }, attributes.audio_file_language) // Display audio_file_language in the editor
            ];
        },    
        save: function () {
            return null; // Rendered on the front-end using PHP callback
        }
    });
})(window.wp);
