(function(blocks, editor, components, i18n, element) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var RichText = editor.RichText;
    var Fragment = element.Fragment;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;

    registerBlockType('gutenberg-tabs/tab', {
        title: i18n.__('Tab'),
        icon: 'screenoptions',
        category: 'common',
        attributes: {
            tabs: {
                type: 'array',
                default: [
                    { title: 'Tab 1', content: 'Content 1' },
                    { title: 'Tab 2', content: 'Content 2' },
                ],
            },
        },

        edit: function(props) {
            var tabs = props.attributes.tabs;

            function updateTabTitle(value, index) {
                var newTabs = tabs.map(function(tab, tabIndex) {
                    if (index === tabIndex) {
                        return { ...tab, title: value };
                    }
                    return tab;
                });

                props.setAttributes({ tabs: newTabs });
            }

            function updateTabContent(value, index) {
                var newTabs = tabs.map(function(tab, tabIndex) {
                    if (index === tabIndex) {
                        return { ...tab, content: value };
                    }
                    return tab;
                });

                props.setAttributes({ tabs: newTabs });
            }

            function addNewTab() {
                var newTabs = [ ...tabs, { title: '', content: '' } ];
                props.setAttributes({ tabs: newTabs });
            }

            function removeTab(index) {
                var newTabs = tabs.filter(function(tab, tabIndex) {
                    return index !== tabIndex;
                });

                props.setAttributes({ tabs: newTabs });
            }

            return el(Fragment, null,
                el(InspectorControls, null,
                    el(components.PanelBody, { title: i18n.__('Tabs') },
                        el(components.Button, {
                            onClick: addNewTab,
                            isPrimary: true
                        }, i18n.__('Add New Tab'))
                    )
                ),
                el('div', { className: props.className },
                    el('ul', { className: 'gutenberg-tabs-tabs' },
                        tabs.map(function(tab, index) {
                            return el('li', { key: index },
                                el(TextControl, {
                                    value: tab.title,
                                    onChange: function(value) {
                                        updateTabTitle(value, index);
                                    },
                                    placeholder: i18n.__('Tab Title')
                                }),
                                el(components.IconButton, {
                                    icon: 'no',
                                    onClick: function() {
                                        removeTab(index);
                                    },
                                    className: 'gutenberg-tabs-remove-button'
                                })
                            );
                        })
                    ),
                    el('div', { className: 'gutenberg-tabs-content' },
                        tabs.map(function(tab, index) {
                            return el('div', { key: index, className: 'gutenberg-tabs-tab-content' },
                                el(RichText, {
                                    tagName: 'h3',
                                    value: tab.title,
                                    onChange: function(value) {
                                        updateTabTitle(value, index);
                                    },
                                    placeholder: i18n.__('Tab Title')
                                }),
                                el(RichText, {
                                    tagName: 'div',
                                    multiline: true,
                                    value: tab.content,
                                    onChange: function(value) {
                                        updateTabContent(value, index);
                                    },
                                    placeholder: i18n.__('Tab Content')
                                })
                            );
                        })
                    )
                )
            );
        },

        save: function(props) {
            var tabs = props.attributes.tabs;

            return el('div', { className: props.className },
                el('ul', { className: 'gutenberg-tabs-tabs' },
                    tabs.map(function(tab, index) {
                        return el('li', { key: index },
                            el('span', null, tab.title)
                        );
                    })
                ),
                el('div', { className: 'gutenberg-tabs-content' },
                    tabs.map(function(tab, index) {
                        return el('div', { key: index, className: 'gutenberg-tabs-tab-content' },
                            el('h3', null, tab.title),
                            el('div', { dangerouslySetInnerHTML: { __html: tab.content } })
                        );
                    })
                )
            );
        }
    });
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.components,
    window.wp.i18n,
    window.wp.element
);
