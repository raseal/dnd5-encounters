# Installation
Run `make build` in order to install all application dependencies (you must have Docker installed).

For more commands, type `make help`

# TODO
* sourcebook (id, name)
* campaign (id, name)
* character (id, name, lvl, hp, ac)
* party (campaign_id, character_id)
* conditions
* spell
* monster

conditins: https://5e.tools/data/conditionsdiseases.json

SPELLS
"""""""
FTB (Fizban's treasury of dragons)
https://5e.tools/data/spells/spells-ftd.json

PHB (Players Handbook)
https://5e.tools/data/spells/spells-phb.json

TCE (Tasah's cauldron of everything)
https://5e.tools/data/spells/spells-tce.json

XGE (Xanathar's Guide to Everything)
https://5e.tools/data/spells/spells-xge.json


BESTIARY (flag: isNpc:true => not a monster)
""""""""
BGDIA (Baldur's Gate: Descent into Avernus)
https://5e.tools/data/bestiary/bestiary-bgdia.json


DMG (Dungeons Master Guide)
https://5e.tools/data/bestiary/bestiary-dmg.json


FTB (Fizban's Treasury of Dragons)
https://5e.tools/data/bestiary/bestiary-ftd.json

MM (Monsters Manual)
https://5e.tools/data/bestiary/bestiary-mm.json

PHB (Players Handbook)
https://5e.tools/data/bestiary/bestiary-phb.json

TCE (Tasha's Cauldron of Everything)
https://5e.tools/data/bestiary/bestiary-tce.json


XGE (Xanathar's Guide to Everything)
https://5e.tools/data/bestiary/bestiary-xge.json
# TODO: endpoints de crear/upd => devuelven el json de la entidad
*******
## Campaigns
PUT, GET, DELETE: campaigns/id

## Characters
POST: characters/
PATCH, GET, DELETE: characters/id

## Monsters
POST: monsters/
GET: monsters/id

## Encounters
GET: encounters/challenge-rate/noideaAboutParams

POST: encounters/
    - campaignId
    - inProgress:false
    - mosnters [
        - [data monster1 or ID?],
        - [data monster2 or ID?],
        - ...
    ]
    - players [
        - [data player1 or ID?],
        - [data player2 or ID?],
        - ...
    ]
    - name
    - round: 0
    - turn: 0

// combat starts! or Next turn! or Undo turn! 
PUT: encounters/id
    - inProgress: true
    - round: 1
    - turn: 1

DELETE: encounters/id


