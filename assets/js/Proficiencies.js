import React from "react";
import ReactDOM from "react-dom";
import ReactLoading from "react-loading";
import { CSSTransition } from 'react-transition-group';
import CircularProgressbar from 'react-circular-progressbar';
import ReactPaginate from 'react-paginate';
export default class Proficiencies extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: true,
            proficiencies: this.props.proficiencies,
            percentages: [],
            page: 0,
            page_count: 0,
            displayProficiencies: []
        };
        this.setProficienciesPage = this.setProficienciesPage.bind(this);
    }

    componentDidMount() {
        this._isMounted = true;
        this.setProficienciesInfo(this.props.proficiencies)

    }
    componentDidUpdate(prevProps) {
        var curProps = this.props;
        if (curProps != prevProps) {
            this._isMounted = true;
            this.setProficienciesInfo(curProps.proficiencies);
        }
    }

    setProficienciesInfo(proficiencies) {
        var count = Math.ceil(proficiencies.length / 5);
        if (this._isMounted) {
            this.setState({proficiencies: proficiencies, page_count: count}, () =>
            {
                this.setProficienciesPercentages();
                this.setDisplayProficiencies();
            });
        }
    }

    setProficienciesPage(data) {
        if (this._isMounted)
            this.setState({page: data.selected}, () => {
                this.setDisplayProficiencies();
            });
    }

    setDisplayProficiencies() {
        var page = this.state.page;
        var count = page * 5;
        var display = [];
        if (this._isMounted) {
            for (var i = count; i < count + 5; i++) {
                if (this.state.proficiencies[i]) {
                    display.push(this.state.proficiencies[i]);
                }
            }
            this.setState({displayProficiencies: display}, () => {
            });
        }

    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    getProficiencyLevel(percent) {
        const level_array = ['Unskilled', 'Novice', 'Beginner', 'Advanced Beginner', 'Familiar', 'Competent', 'Skilled', 'Proficient', 'Advanced', 'Expert', 'Master'];
        var level = (percent - (percent % 10)) / 10;
        return level_array[level];
    }

    setProficienciesPercentages() {
        if (this._isMounted) {
            var counters = [];
            var proficiencies = this.state.proficiencies;
            var intervals = [];
            var percentages = this.state.percentages;
            Object.keys(proficiencies).map(proficiency => {
                var percent = proficiencies[proficiency].percent;
                counters[proficiency] = 0;
                if (percentages[proficiency] && percentages[proficiency] != percent) {
                    return;
                } else {
                    intervals[proficiency] = setInterval(() => {
                        if (counters[proficiency] <= percent) {
                            percentages[proficiency] = counters[proficiency];
                            this.setState({percentages: percentages});
                            counters[proficiency] = counters[proficiency] + 5;
                        } else {
                            percentages[proficiency] = percent;
                            this.setState({percentages: percentages});
                            clearInterval(intervals[proficiency]);
                            intervals[proficiency] = null;
                            counters[proficiency] = 0;
                        }

                    }, 20);
                }
            });
        }
    }

    proficienciesDom() {
        var proficiencies = this.state.displayProficiencies;
        var page = this.state.page;
        var proficiencies_dom = Object.keys(proficiencies).map(proficiency => {
            var proficiency_count = parseInt(proficiency) + (parseInt(page) * 5);
            var percent_final = proficiencies[proficiency].percent;
            var percent = this.state.percentages[proficiency_count];
            var percent_value = percent == percent_final ? this.getProficiencyLevel(percent_final) : this.state.percentages[proficiency_count] + "%";
            var percent_text = <div className="percent-content-container position-absolute w-100 h-100 text-center"><span className="percent-content d-inline-block w-100 text-three light position-absolute">{percent_value}</span></div>;
            var icon = proficiencies[proficiency].icon ? <i className={"fab fa-" + proficiencies[proficiency].icon + " text-three light"}></i> : "";
            return(<div key={"prof-" + proficiency} className="row resume-proficiency-section my-3 text-center" >
                <div className="proficiency-name col-lg-4 offset-lg-2 col-md-5 offset-md-1 col-6 align-self-center">
                    <span className="proficiency-icon d-inline-block align-middle mx-1">{icon}</span>
                    <span className="proficiency-name-inline d-inline-block align-middle mx-1">
                        <h2 className="proficiency-text text-three light">
                            {proficiencies[proficiency].title}
                        </h2>
                    </span>
                    <div className="proficiency-years align-self-center">
                        <h5 className="proficiency-time text-three light">Years of practice: {proficiencies[proficiency].years} </h5>
                    </div>
                </div>
                <div className="proficiency-percent col-lg-4 col-md-5 col-6 align-self-center px-0">
                    <CircularProgressbar
                        percentage={percent}
                        initialAnimation={true}
                        circleRatio={0.75}
                        className={'percent-indicator'}
                        styles={{
                                            // Customize the root svg element
                                            root: {
                                                width: "30%",
                                            },
                                            // Customize the path, i.e. the "completed progress"
                                            path: {
                                                // Path color
                                                // stroke: `rgba(theme-color("one"), ${percent / 100})`,
                                                // Whether to use rounded or flat corners on the ends - can use 'butt' or 'round'
                                                strokeLinecap: 'round',
                                                // Customize transition animation
                                                transition: 'stroke-dashoffset 0.1s ease 0s',
                                                transform: 'rotate(-135deg)',
                                                transformOrigin: 'center center',
                                            },
                                            // Customize the circle behind the path, i.e. the "total progress"
                                            trail: {
                                                strokeLinecap: 'round',
                                                transform: 'rotate(-135deg)',
                                                transformOrigin: 'center center',
                                            },
                                            // Customize the text
                                            text: {
                                                // Text color
                                                // fill: 'theme-color("one")',
                                                // Text size
                                                fontSize: '16px',
                                            },
                                        }}
                        />
                    {percent_text}
                </div>
            
            </div>);
        });
        return proficiencies_dom;
    }

    render() {
        var proficiencies_dom = (
                <CSSTransition
                    in={true}
                    appear={true}
                    timeout={1000}
                    classNames="fade"
                    >
                    <div id="proficienciesDomWrapper" className="w-100 content-element position-absolute bg-three op-9 pb-5">
                        <div id="proficienciesDomContainer" className="container-fluid">
                            <div className="row">
                                <h2 className="section-title text-center col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 text-three light">Skills</h2>
                            </div>
                            <div className="row resume-proficiency-labels my-3 text-center" >
                                <div className="proficiency-label col-lg-4 offset-lg-2 col-md-5 offset-md-1 col-6 align-self-center text-three dark">
                                    <strong>Proficiency</strong>
                                </div>
                                <div className="proficiency-label col-lg-4 col-md-5 col-6 align-self-center bold text-three dark">
                                    <strong>Level Of Mastery</strong>
                                </div>
                            </div>
                            {this.proficienciesDom()}
                
                            <div id="historiesPaginationRow" className="row">
                                <div className="col-6 offset-3 d-flex justify-content-center">
                                    <ReactPaginate
                                        previousLabel={ < i class = "far fa-arrow-alt-circle-left" > </i>}
                                        nextLabel={ < i class = "far fa-arrow-alt-circle-right" > </i>}
                                        breakLabel={'...'}
                                        breakClassName={'break-me'}
                                        pageCount={this.state.page_count}
                                        marginPagesDisplayed={2}
                                        pageRangeDisplayed={3}
                                        onPageChange={this.setProficienciesPage}
                                        containerClassName={'pagination'}
                                        subContainerClassName={'pages pagination'}
                                        activeClassName={'active'}
                                        pageLinkClassName={'btn btn-outline-three dark'}
                                        previousLinkClassName={'btn btn-outline-three dark'}
                                        nextLinkClassName={'btn btn-outline-three dark'}
                                        pageClassName={'mx-1'}
                                        previousClassName={'mx-1'}
                                        nextClassName={'mx-1'}
                                        disabledLinkClassName={'disabled'}
                                        activeLinkClassName={'active'}
                
                                        />
                                </div>
                            </div>
                        </div>
                    </div>
                </CSSTransition>
                );

        return proficiencies_dom;
    }

};




