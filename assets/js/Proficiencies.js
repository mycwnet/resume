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
                            counters[proficiency] = counters[proficiency] + 1;
                        } else {
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
            var percent = this.state.percentages[proficiency_count];
            var icon = proficiencies[proficiency].icon ? <i className={"fab fa-" + proficiencies[proficiency].icon + " fa-3x text-three light"}></i> : "";
            return(<div key={"prof-" + proficiency} className="row resume-proficiency-section my-3 text-center" >
                <div className="proficiency-name col-lg-3 offset-lg-1 col-8 offset-2 align-self-center">
                    <span className="proficiency-icon d-inline-block align-middle mx-1">{icon}</span>
                    <span className="proficiency-name-inline d-inline-block align-middle mx-1">
                        <div className="proficiency-label text-center text-three dark"> Proficiency Name </div>
                        <h2 className="text-three light">
                            {proficiencies[proficiency].title}
                        </h2>
                    </span>
                </div>
                <div className="proficiency-years col-lg-3 col-4 offset-2 align-self-center">
                    <div className="proficiency-label text-center text-three dark">Years of Practice</div>
                    <h2 className="text-three light">{proficiencies[proficiency].years} </h2>
                </div>
                <div className="proficiency-percent col-lg-3 col-4 align-self-center">
                    <div className="proficiency-label text-center text-three dark">Mastery</div>
                    <CircularProgressbar
                        percentage={percent}
                        text={`${percent}%`}
                        initialAnimation={true}
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
                                            },
                                            // Customize the circle behind the path, i.e. the "total progress"
                                            trail: {
                                                // Trail color
                                                //stroke: 'theme-color("one")',
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
                    <div id="proficienciesDomWrapper" className="w-100 content-element position-absolute bg-three op-9">
                        <div id="proficienciesDomContainer" className="container h-100">
                            <div className="row">
                                <h2 className="section-title text-center col-10 offset-1 text-three light font-size-5">Skills</h2>
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
                                        pageRangeDisplayed={0}
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




