(function(wp) {
    var el = wp.element.createElement;
    var __ = wp.i18n.__;
    
    var ServerSideRender  = wp.components.ServerSideRender;
    
    wp.blocks.registerBlockType(
        'wp-school-calendar/wp-school-calendar', {
            title: __( 'WP School Calendar', 'wp-school-calendar' ),
            description: __( 'Display school calendar.', 'wp-school-calendar' ),
            icon: 'calendar-alt',
            category: 'widgets',
            edit: function( props ) {
                return [
                    el(ServerSideRender, {
                        block: "wp-school-calendar/wp-school-calendar",
                        attributes: props.attributes
                    })
                ];
            },
            save: function() {
                return null;
            }
        }
    );

})(
    window.wp
);