import React from "react";
import ReactDOM from "react-dom";
import ReactLoading from "react-loading";

export default class Histories extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            histories: this.props.histories
        };
    }

    componentDidMount() {
        this._isMounted = true;
        this.setHistoriesInfo(this.props.histories);
    }

    componentWillReceiveProps(nextProps) {
        this._isMounted = true;
        this.setHistoriesInfo(nextProps.histories);
    }

    setHistoriesInfo(histories) {
        if (this._isMounted)
            this.setState({histories: histories});
    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    historiesDom() {
        var histories = this.state.histories;
        console.log("hState: " + JSON.stringify(this.state));
        console.log("hProps: " + JSON.stringify(this.props));
        var histories_dom = Object.keys(histories).map(history => {
            console.log("hist: " + JSON.stringify(history));
            return(<div key={"hist-" + history}
                 className="col-lg-4 col-md-12 col-sm-12 resumeHistorySection"
                 >
                <h2 className="historyName">
                    {histories[history].title}
                </h2>
                <p className="historyDescription">
                    {histories[history].description}
                </p>
                <div className="historyStart">
                    {histories[history].start.date}
                </div>
                <div className="historyEnd">
                    {histories[history].end.date}
                </div>
            
            </div>);
        });

        return histories_dom;
    }

    render() {
        console.log("histories: " + JSON.stringify(this.state.histories));
        var histories_dom = (
                <div id="historiesDomWrapper">
                    <div id="historiesDomContainer" className="row">
                        {this.historiesDom()}
                    </div>
                </div>
                );

        return histories_dom;
    }

};
