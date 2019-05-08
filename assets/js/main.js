import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import ReactLoading from "react-loading";
import ProfileDisplay from "./ProfileDisplay"
import { BrowserRouter as Router, Route, Link } from "react-router-dom";

export default class Main extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            stateVars: [],
            pathVars: "",
            mountCount: 0
        };

        this.setProfileValues = this.setProfileValues.bind(this);
    }

    componentDidMount() {
        this._isMounted = true;
    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    setProfileValues(location, count) {
        this.setState(
                {
                    pathVars: location.hash,
                    stateVars: location.state ? location.state : [],
                    mountCount: count
                }

        );


    }

    render() {
        return (
                <Router>
                    <div>
                        <ProfileDisplay stateVars={this.state.stateVars} pathVars={this.state.pathVars}/>
                
                        <Route exact path="/"
                               component={({ match, location, history }) =>
                                       (<RouteParser 
                                        componentProps={{
                                                                               pathVars: location.hash,
                                                                               stateVars: location.state ? location.state : [],
                                                                               hist: history,
                                                                               loc: location,
                                                                               match: match,
                                                                               setProfileValues: this.setProfileValues,
                                                                               mountCount: this.state.mountCount
                                                                           }} />)
                            }/>
                    </div>
                </Router>
                );
    }
};

class RouteParser extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            stateVars: props.componentProps.stateVars,
            pathVars: props.componentProps.pathVars,
            mountCount: props.componentProps.mountCount
        };
    }

    componentDidUpdate(prevProps) {
        this._isMounted = true;
        var curProps = this.props;
        var curPath = curProps.componentProps.pathVars;
        var prevPath = prevProps.componentProps.pathVars;
        if (curPath !== prevPath) {
            this.setStateVariables(this.props, 0);
        }
    }
    componentDidMount() {
        this._isMounted = true;
        var mountProps = this.props ? this.props : [];

        if (this.state.mountCount < 2 && mountProps.componentProps.pathVars) {
            this.setStateVariables(mountProps, this.state.mountCount);
        }
    }
    componentWillUnmount() {
        this._isMounted = false;
    }
    setStateVariables(propsVars, count) {
        if (this._isMounted) {
            this.setState(
                    {
                        stateVars: propsVars.componentProps.stateVars,
                        pathVars: propsVars.componentProps.pathVars
                    }
            );
            count += 1;
            propsVars.componentProps.setProfileValues(propsVars.componentProps.loc, count);

        }
    }

    render() {
        return(<div />);
    }
}
