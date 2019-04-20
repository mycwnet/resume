import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Route, Link } from "react-router-dom";


export default class ProfileDisplayHeader extends React.Component {
    render() {
        return (
                <Router>
                    <div>
                        <nav>
                            <ul>
                                <li>
                                    <Link to="/">Home</Link>
                                </li>
                                <li>
                                    <Link to="/about/">About</Link>
                                </li>
                                <li>
                                    <Link to="/users/">Users</Link>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </Router>
                );
    }
}