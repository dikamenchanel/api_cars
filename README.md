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

- **Parameters for Pagination**
    - ``` page ``` (integer, optional): Serial page.
    - ``` perPage ``` (integer, optional): Number of elements on the page.
  
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

  - Optional
```json
{
    "countPage":""
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

#### Error Responses

- **Response**
```json
{
  "status" : "error",
  "message" : "This id not found in Base",
  "data" : [] 
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

#### Error Responses

- **Response**
```json
{
  "status" : "error",
  "message" : "No cars found for the given parameters.",
  "data" : [] 
}
```
- **Response**
```json
{
  "status" : "error",
  "message" : "No parameters used. Use at least one set of parameters: fromPrice/toPrice or fromYear/toYear, and optionally mark.",
  "data" : [] 
}
```





### Create Car

#### Create car based on required and optional parameters.
- **URL**
    - POST
    - ```url /cars/add ```

- **Parameters**
    - *Query Body Params*
      - ``` brand ``` (string, required): Brand of the car.
      - ``` model ``` (string, required): Model of the car.
      - ``` price ``` (float, optional):  Price of the car.
      - ``` year ``` (integer, optional): Year of the car.
      - ``` images ``` (string, optional): Array names cars convert to string "car1.jpg, car2.jpg, car3.jpg, car4.jpg". 

- **Response**
   - Return ``` id ``` Insert data
```json
{
  "status": "success",
  "message": "Post has been created",
  "data": ["id": 1]
}
```

#### Error Responses

- **Response**
```json
{
  "status" : "error",
  "message" : "The following fields are required for submitting parameters: - brand - model - year - price - images",
  "data" : [] 
}
```



### Update Car

#### Update car based on optional parameters.
- **URL**
    - POST
    - ```url /cars/edit/{id} ```

- **Parameters**
    - *Query String*
      - ``` id ``` (integer): ID of the car to retrieve.
    
    - *Query Body Params*
      - ``` brand ``` (string, optional): Brand of the car.
      - ``` model ``` (string, optional): Model of the car.
      - ``` price ``` (float, optional):  Price of the car.
      - ``` year ``` (integer, optional): Year of the car.
      - ``` images ``` (string, optional): Array names cars convert to string "car1.jpg, car2.jpg, car3.jpg, car4.jpg". 

- **Response**
   - Return ``` id ``` Update data
```json
{
  "status": "success",
  "message": "Post has been updated",
  "data": ["id": 1]
}
```

#### Error Responses

- **Response**
```json
{
  "status" : "error",
  "message" : "There is no data to update, or there is no such record in the database",
  "data" : [] 
}
```


### Delete Car

#### Delete car.
- **URL**
    - POST
    - ```url /cars/del/{id} ```

- **Parameters**
    - *Query String*
      - ``` id ``` (integer): ID of the car to retrieve.
 

- **Response**
```json
{
  "status": "success",
  "message": "Entry has been deleted",
  "data": []
}
```

#### Error Responses

- **Response**
```json
{
  "status" : "error",
  "message" : "Something went wrong, perhaps your data is not in the database",
  "data" : [] 
}
```


## Error Default Responses

### Error Responses


- **Response**
```json
{
  "status" : "error",
  "message" : "Url Not Found",
  "data" : [] 
}
```

### Example Usage
```bash
curl -X GET http://example.com/api/cars
```



