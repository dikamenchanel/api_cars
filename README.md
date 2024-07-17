# API Documentation

## Car API

### Start Page

Returns a empty array, start page.

- **URL**
    - GET
    - ```url / ```

- **Response**
```json
{
  "status": "success",
  "message": "Work My Rest FULL Api",
  "data": []
}
```

### Get All Cars

#### Returns a list of all cars available.

- **URL**
    - GET
    - ```url /cars ```

- **Parameters**
    - not parameter
  
- **Response**
```json
{
    "status":"success",
    "message":"",
    "data":[
            {
                "id":1,
                "url":"toyota",
                "brand":"Toyota",
                "model":"Camry",
                "year":2015
            },
            {
                "id":2,
                "url":"honda",
                "brand":"Honda",
                "model":"Accord",
                "year":2018
            },
            {
                "id":3,
                "url":"ford",
                "brand":"Ford",
                "model":"F-150",
                "year":2016
            },
            ....
        ]
}
```


### Get Car by ID

#### Returns details of a car based on its ID.

- **URL**
    - GET
    - ```url /cars/{id} ```

- **Parameters**
    - ``` id ``` (integer): ID of the car to retrieve.
- **Response**
```json
{
  "status": "success",
  "message": "Work My Rest FULL Api",
  "data": {
    "id": 1,
    "brand": "Toyota",
    "model": "Corolla",
    "year": 2020,
    "images": ["image1.jpg", "image2.jpg"]
  }
}
```


### Filter Cars

#### Filters cars based on optional parameters.
- **URL**
    - GET
    - ```url /cars/filter ```

- **Parameters**
    - ``` mark ``` (string, optional): Brand of the car.
    - ``` fromPrice ``` (float, optional): Price range.
    - ``` toPrice ``` (float, optional): Price range.
    - ``` fromYear ``` (integer, optional): Year range.
    - ``` toYear ``` (integer, optional): Year range. 

- **Response**
```json
{
  "status": "success",
  "message": "Request completed successfully",
  "data": [
    {
      "id": 1,
      "brand": "Toyota",
      "model": "Corolla",
      "year": 2020,
      "images": ["image1.jpg", "image2.jpg"]
    },
    {
      "id": 2,
      "brand": "Honda",
      "model": "Accord",
      "year": 2021,
      "images": ["image3.jpg"]
    }
  ]
}
```

### Error Responses

- **Response**
```json
{
  "status": "error",
  "message": "URL Not Found"
}
```
  
