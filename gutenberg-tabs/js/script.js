(function (blocks, editor, components, i18n, element) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var TabPanel = components.TabPanel;

    blocks.registerBlockType('gutenberg-tabs/tab', {
        title: i18n.__('Tab', 'gutenberg-tabs'),
        icon: 'list-view',
        category: 'common',

        attributes: {
            tabs: {
                type: 'array',
                default: [
                    {
                        title: i18n.__('Tab 1', 'gutenberg-tabs'),
                        content: '',
                    },
                    {
                        title: i18n.__('Tab 2', 'gutenberg-tabs'),
                        content: '',
                    },
                ],
            },
        },

        edit: function (props) {
            var tabs = props.attributes.tabs;

            function onTabChange(newTabs) {
                props.setAttributes({ tabs: newTabs });
            }

            return el(
                TabPanel,
                {
                    className: props.className,
                    activeClass: 'active-tab',
                    onSelect: onTabChange,
                    tabs: tabs.map(function (tab) {
                        return {
                            name: tab.title,
                            title: tab.title,
                            className: 'tab-' + tab.title.toLowerCase().replace(' ', '-'),
                        };
                    }),
                },
                function (tab) {
                    var tabContent = tabs.find(function (t) {
                        return t.title === tab.name;
                    });

                    return el(
                        RichText,
                        {
                            tagName: 'div',
                            className: 'gutenberg-tabs-tab-content',
                            value: tabContent.content,
                            onChange: function (newContent) {
                                var newTabs = tabs.map(function (t) {
                                    if (t.title === tabContent.title) {
                                        return Object.assign({}, t, { content: newContent });
                                    }
                                    return t;
                                });
                                onTabChange(newTabs);
                            },
                        }
                    );
                }
            );
        },

        save: function (props) {
            var tabs = props.attributes.tabs;

            return el(
                'div',
                { className: props.className },
                el(
                    'ul',
                    { className: 'gutenberg-tabs-tabs' },
                    tabs.map(function (tab, index) {
                        return el(
                            'li',
                            { key: index },
                            el('span', null, tab.title)
                        );
                    })
                ),
                el(
                    'div',
                    { className: 'gutenberg-tabs-content' },
                    tabs.map(function (tab, index) {
                        return el(
                            'div',
                            {
                                key: index,
                                className: 'gutenberg-tabs-tab-content',
                                style: { display: index === 0 ? 'block' : 'none' },
                            },
                            el('h3', null, tab.title),
                            el('div', { dangerouslySetInnerHTML: { __html: tab.content } })
                        );
                    })
                )
            );
        },
    });
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.components,
    window.wp.i18n,
    window.wp.element
);
