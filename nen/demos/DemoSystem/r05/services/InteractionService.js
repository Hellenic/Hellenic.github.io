"use strict";
var InteractionService = {};

/**
* InteractionService
*
* @class InteractionService
*/
(function(Service) {

    var textFileFolder = "interactions/";

    Service.getInteractionByMesh = function(mesh)
    {
        if (!(mesh instanceof THREE.Mesh))
        {
            return;
        }

        return mesh.userData.interaction;
    };

    Service.apply = function(interaction, mesh)
    {
        if (interaction.textFile)
        {
            console.log("interaction", textFileFolder + interaction.textFile);
            // TODO What if this takes a long time?
            $.getJSON(textFileFolder + interaction.textFile, function(fileContent) {
                console.log("FileContent", fileContent);
                interaction.texts = fileContent;
                interaction.apply(mesh);
                return true;
            });
        }

        interaction.apply(mesh);
        return true;
    };

})(InteractionService);
