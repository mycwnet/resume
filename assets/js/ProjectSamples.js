import React from "react";
import ReactDOM from "react-dom";
import ReactLoading from "react-loading";
import { CSSTransition } from 'react-transition-group';

export default class ProjectSamples extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            samples: this.props.samples
        };
    }

    componentDidMount() {
        this._isMounted = true;
        this.setProjectSamplesInfo(this.props.samples);
    }

    componentWillReceiveProps(nextProps) {
        this._isMounted = true;
        this.setProjectSamplesInfo(nextProps.samples);
    }

    setProjectSamplesInfo(samples) {
        if (this._isMounted)
            this.setState({samples: samples});
    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    projectSamplesDom() {
        var samples = this.state.samples;
        var samples_dom = Object.keys(samples).map(sample => {
            return(<div key={"samp-" + sample}
                 className="col-lg-4 col-md-12 col-sm-12 resume-project-samples-section"
                 >
                <h2 className="sample-name">
                    {samples[sample].title}
                </h2>
                <div className="sample-blurb">
                    {samples[sample].blurb}
                </div>
                <div className="sample-link">
                    {samples[sample].link}
                </div>
                <div className="sample-image">
                    {samples[sample].project_image}
                </div>
            
            </div>);
        });

        return samples_dom;
    }

    render() {
        var samples_dom = (
                <CSSTransition
                    in={true}
                    appear={true}
                    timeout={1000}
                    classNames="fade"
                    >
                    <div id="projectSamplesDomWrapper" className="container position-absolute">
                        <div id="projectSamplesDomContainer" className="row">
                            {this.projectSamplesDom()}
                        </div>
                    </div>
                </CSSTransition>
                );

        return samples_dom;
    }

};




