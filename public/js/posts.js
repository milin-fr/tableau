console.log("posts test");

class LikeButton extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            likes: props.likes || 0,
            isLiked: props.iLiked || false
        };
    }

    render() {
        return React.createElement('button', {className: 'btn btn-link'}, "j'aime");
    }
}

document.querySelectorAll('span.react-like').forEach(function(span){
    ReactDOM.render(React.createElement(LikeButton), span);
});
