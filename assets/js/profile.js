import React from 'react';

var $ = require('jquery');

var projectHistoryCollection;
var proficiencyCollection;
var addProjectHistoryButton = $('<button type="button" class="btn btn-secondary my-2 add_project_history">Add Project</button>');
var addProficiencyButton = $('<button type="button" class="btn btn-secondary my-2 add_proficiency">Add Proficiency</button>');
$(document).ready(function () {
    projectHistoryCollection = $('#project_history_list');
    proficiencyCollection = $("#proficiencies_list");

    //set index value for project history collections
    projectHistoryCollection.data('index', projectHistoryCollection.find('.card').length);
    var histindex = 0;
    projectHistoryCollection.find('.card').each(function () {
        histindex = histindex + 1;
        addDeleteHistoryButton($(this), histindex);
    });
    projectHistoryCollection.append(addProjectHistoryButton);

    addProjectHistoryButton.click(function (e) {
        e.preventDefault();
        addProjectHistoryCollection();
    });

    //set index value for proficiencies collections
    proficiencyCollection.data('index', proficiencyCollection.find('.card').length);
    var profindex = 0;
    proficiencyCollection.find('.card').each(function () {
        profindex = profindex + 1;
        addDeleteProficiencyButton($(this), profindex);
    });
    proficiencyCollection.append(addProficiencyButton);

    addProficiencyButton.click(function (e) {
        e.preventDefault();
        addProficiencyCollection();
    });
});

function addProjectHistoryCollection() {
    var prototype = projectHistoryCollection.data('prototype');

    var index = projectHistoryCollection.data('index');

    var projectForm = prototype.replace(/__name__/g, index);

    projectHistoryCollection.data('index', index + 1);

    var projectHistoryCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var project = $('<div class="card-body"></div>').append(projectForm);

    projectHistoryCard.append(project);
    addDeleteHistoryButton(projectHistoryCard, index + 1);

    addProjectHistoryButton.before(projectHistoryCard);
}

function addDeleteHistoryButton(project, index) {

    //console.log(index);
    if (index > 1) {
        var deleteProjectHistoryButton = $('<button type="button" class="btn btn-warning my-2 del_project_history">Remove Project</button>');

        var cardfooter = $('<div class="card-footer"></div>').append(deleteProjectHistoryButton);
        deleteProjectHistoryButton.click(function (e) {
            e.preventDefault();
            $(e.target).parents('.card').remove();
        });

        project.append(cardfooter);
    }

}

function addProficiencyCollection() {

    var prototype = proficiencyCollection.data('prototype');

    var index = proficiencyCollection.data('index');

    var proficiencyForm = prototype.replace(/__name__/g, index);

    proficiencyCollection.data('index', index + 1);

    var proficiencyCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var proficiency = $('<div class="card-body"></div>').append(proficiencyForm);

    proficiencyCard.append(proficiency);
    addDeleteProficiencyButton(proficiencyCard, index + 1);

    addProficiencyButton.before(proficiencyCard);
}

function addDeleteProficiencyButton(proficiency, index) {

    //console.log(index);
    if (index > 1) {
        var deleteProficiencyButton = $('<button type="button" class="btn btn-warning my-2 del_proficiency">Remove Proficiency</button>');

        var cardfooter = $('<div class="card-footer"></div>').append(deleteProficiencyButton);
        deleteProficiencyButton.click(function (e) {
            e.preventDefault();
            $(e.target).parents('.card').remove();
        });

        proficiency.append(cardfooter);
    }

}