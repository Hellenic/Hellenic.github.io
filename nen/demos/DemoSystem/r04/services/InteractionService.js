"use strict";
var InteractionService = {};

/**
* InteractionService
*
* @class InteractionService
*/
(function(Service) {

    var interactions = [];

    Service.getInteractionByMesh = function(mesh)
    {
        if (!(mesh instanceof THREE.Mesh))
        {
            return;
        }

        return mesh.userData.interaction;
    };

})(InteractionService);
