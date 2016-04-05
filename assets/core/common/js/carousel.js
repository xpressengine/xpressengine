'use strict'

var Carousel = React.createClass({
    propsTypes: {
        items: React.PropTypes.array.isRequired,
        name: React.PropTypes.string,
        infoDrawer: React.PropTypes.function
    },
    getDefaultProps() {
        return {
            selectedId: null,
            infoDrawer: null
        };
    },
    getInitialState() {
        return {
            items: [],
            innerHeight: 0,
            activeIdx: null,
            targetIdx: null,
            direction: null,
            sliding: false,
            selectedId: null
        };
    },
    componentWillMount() {
        var self = this;
		window.addEventListener("resize", function () {
            self.updateInnerHeight();
        });
    },
    componentDidMount() {
        this.updateInnerHeight();

        this.setState({
            items: this.props.items,
            selectedId: this.props.selectedId
        });

        var startIdx = 0;
        this.props.items.map(function (item, idx) {
            if (this.props.selectedId === item.id) {
                startIdx = idx;
            }
        }.bind(this));

        this.moveTo(startIdx);
    },
    updateInnerHeight() {
        var dom = this.getDOMNode(),
            innerWidth = parseInt($(dom).width());

        this.setState({innerHeight: parseInt(innerWidth * 0.8)});
    },
    slideRight (e){
        e.preventDefault();

        var targetIdx = this.state.activeIdx - 1;
        if (targetIdx < 0) {
            targetIdx = this.state.items.length - 1;
        }

        this.moveTo(targetIdx, 'right');
	},

	slideLeft (e){
        e.preventDefault();

        var targetIdx = this.state.activeIdx + 1;
        if (targetIdx > this.state.items.length - 1) {
            targetIdx = 0;
        }

        this.moveTo(targetIdx, 'left');
	},
	moveTo (position, direction) {
        if (this.state.sliding === true || this.state.activeIdx === position) {
            return false;
        }

        this.setState({sliding: true});
        if (!direction) {
            this.setState({activeIdx: position, targetIdx: null, direction: null, sliding: false});
        } else {
            this.setState({targetIdx: position, direction: direction});

            setTimeout(function () {
                this.setState({activeIdx: position, targetIdx: null, direction: null, sliding: false});
            }.bind(this), 600);
        }
	},
    drawItemInfo(item) {
        if (this.props.infoDrawer) {
            return this.props.infoDrawer(item);
        } else {
            return (
                <div>
                    <h3>{item.title}</h3>
                    <p>
                        {item.description}
                        {function () {
                            if (item.link) {
                                return (
                                    <span className="links">
                                        <a href={item.link} target="_blank"><i className="xi-external-link xi-x"></i></a>
                                    </span>
                                );
                            }
                        }.call(this)}
                    </p>
                </div>
            );
        }
    },
    renderItems() {
        return this.state.items.map(function(item, idx){
            var classNames = ['item'],
                isActive = this.state.activeIdx == idx,
                isTarget = this.state.targetIdx == idx;
            if (isActive) {
                classNames.push('active');
            } else if (isTarget) {
                if (this.state.direction == 'left') {
                    classNames.push('next');
                } else if (this.state.direction == 'right') {
                    classNames.push('prev');
                }
            }

            if (this.state.direction !== null && (isActive || isTarget)) {
                classNames.push(this.state.direction);
            }

            var style = {
                height: this.state.innerHeight + 'px',
                lineHeight: this.state.innerHeight + 'px',
                overflow: 'hidden',
                cursor: 'pointer'
            };

            return (
                <div className={classNames.join(' ')} style={style} ref={'item'+idx} key={item.id} onClick={this.selectItem.bind(this, item.id)}>
                    <img src={item.src} />
                    <div className="crs-caption">
                        {this.drawItemInfo(item)}
                    </div>
                    {function () {
                        if (this.state.selectedId == item.id) {
                            return <div className="check active"><i className="xi-check"></i></div>;
                        } else {
                            return <div className="check"><i className="xi-check"></i></div>;
                        }
                    }.call(this)}
                </div>
            );
        }.bind(this));
    },
    renderIndicator() {
        return (
            <ol className="crs-indicators">
                {this.state.items.map(function (item, idx) {
                    var direction = this.state.activeIdx > idx ? 'right' : 'left',
                        className = this.state.activeIdx == idx ? 'active' : '';
                    return <li onClick={this.moveTo.bind(this, idx, direction)} className={className} key={'indicator_' + item.id}></li>;
                }.bind(this))}
            </ol>
        );
    },
    selectItem(id) {
        this.setState({selectedId: id});
    },
    render() {
        return (
            <div className="crs">
                <input type="hidden" name={this.props.name} value={this.state.selectedId} />
                {this.renderIndicator()}

                <div className="crs-inner" role="listbox" style={{height: this.state.innerHeight + 'px'}}>
                    {this.renderItems()}
                </div>

                <a className="left crs-control" href="#" role="button" onClick={this.slideRight}>
                    <i className="xi-caret-left"></i>
                </a>
                <a className="right crs-control" href="#" role="button" onClick={this.slideLeft}>
                    <i className="xi-caret-right"></i>
                </a>
            </div>
        );
    }
});
