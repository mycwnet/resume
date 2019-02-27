import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import ReactLoading from "react-loading";
import ProfileDisplay from "./ProfileDisplay"

export default class Main extends React.Component {
  render() {
    return (
      <div>
        <ProfileDisplay/>
      </div>
    );
  }
};

