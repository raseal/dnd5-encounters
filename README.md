# Installation
Run `make build` in order to install all application dependencies (you must have Docker installed).

For more commands, type `make help`

# Usage
This project exposes a RESTful API that allows creating and running encounters.

The main purpose of this project is to quickly create encounters: all the information about monsters is already loaded in the system so the **Dungeon Master** only have to select which players / creatures will participate in the fight.

The typical flow to create encounters is:
* The **Dungeon Master** creates a campaign.
* The **Dungeon Master** fills the basic information of each player participating in the campaign.
* The **Dungeon Master** creates an encounter specifying which monsters and players will participate. 

There are some endpoints too for modifying the character info (such as their AC, their level...), the encounter info or even for deleting said entities.

# Available endpoints
### Campaign endpoints:
| Endpoint       | Method   | Description                  | Payload                                |
|----------------|----------|------------------------------|----------------------------------------|
| campaigns/     | `POST`   | Creates a campaign.          | [View sample](#campaigns-post-payload) |
| campaigns/     | `GET`    | Retrieves all campaigns.     | WIP                                    |
| campaigns/{id} | `GET`    | Retrieves specific campaign. | -                                      |
| campaigns/{id} | `PUT`    | Edits specific campaign.     | WIP                                    |
| campaigns/{id} | `DELETE` | Removes specific campaign.   | WIP                                    |

### Character endpoints:
| Endpoint        | Method   | Description                   | Payload                                 |
|-----------------|----------|-------------------------------|-----------------------------------------|
| characters/     | `POST`   | Creates a character.          | [View sample](#characters-post-payload) |
| characters/     | `GET`    | Retrieves all characters.     | WIP                                     |
| characters/{id} | `GET`    | Retrieves specific character. | WIP                                     |
| characters/{id} | `PUT`    | Edits specific character.     | WIP                                     |
| characters/{id} | `DELETE` | Removes specific character.   | WIP                                     |

### Monster endpoints (read-only):
| Endpoint        | Method   | Description                                            | Available filters   |
|-----------------|----------|--------------------------------------------------------|---------------------|
| monsters/       | `GET`    | Retrieves all monsters matching the specified filters. | `name` and `source` |

All the monsters' information is automatically inserted when you install the application. The existing source-books are:
- `bgdia` => Baldur's Gate: Descent into Avernus 
- `dmg`=> Dungeon's Master Guide
- `ftd` => Fizban's Treasury of Dragons
- `mm` => Monster's Manual
- `phb` => Player's Handbook
- `tce` => Tasha's Cauldron of Everything
- `xge` => Xanathar's Guide of Everything

Since this endpoint is read-only, the filters must be specified via the query-string. Please note the `source` filter matches with the abbreviation (e.g., use `mm` instead of `Monster's Manual`).
```html
<!-- This retrieves the first 10 monsters from the "Monster Manual" which name contains the word "dragon" -->
/monsters?filter[name][like]=dragon&filter[source][like]=mm&page=1&limit=10

<!-- This retrieves the first dragon from the "Fizban's Treasury" -->
/monsters?filter[name][like]=dragon&filter[source][like]=ftd&page=1&limit=10
```
### Encounter endpoints:
| Endpoint        | Method   | Description                   | Payload                                 |
|-----------------|----------|-------------------------------|-----------------------------------------|
| encounters/     | `POST`   | Creates an encounter.         | [View sample](#encounters-post-payload) |
| encounters/     | `GET`    | Retrieves all encounters.     | WIP                                     |
| encounters/{id} | `GET`    | Retrieves specific encounter. | WIP                                     |
| encounters/{id} | `PUT`    | Edits specific encounter.     | WIP                                     |
| encounters/{id} | `DELETE` | Removes specific encounter.   | WIP                                     |
---
### ANNEX: Payload list 
#### campaigns-post-payload
```json
{
	"campaignName": "Descent into Avernus",
	"campaignActive": "0" // possible values: "0" or "1"
}
```
#### characters-post-payload
```json
{
  "characterName": "Mike",
  "playerName": "Bob Herzog",
  "campaignId": "1e992bef-2c5e-4615-bdd7-489250253896",
  "characterLevel": 5,
  "characterAc": 20,
  "characterHp": 34,
  "characterSpeed": "30",
  "characterImg": "mike_the_basic_warrior.png"
}
```
#### encounters-post-payload
```json
{
  "campaignId": "1e992bef-2c5e-4615-bdd7-489250253896",
  "encounterName": "My first encounter",
  "monsters": [
    {
      "name": "ancient white dragon",
      "sourceBook": "mm",
      "quantity": 1
    },{
      "name": "aboleth",
      "sourceBook": "mm",
      "quantity": 4
    }],
  "playersIds": [
    "6a45ebe6-164e-4e7f-9a56-ffc15d0f83ac",
    "6a45ebe6-164e-4e7f-9a56-ffc15d0f83ab"
  ]
}
```
