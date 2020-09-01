# sv_orderapp

## introduction
This is the first application I made five months after I started programming. In this case there was a fierce amount of pressure. At the beginning of the Corona-crisis cafe's had to stay closed but there was one possibility to make money. People could order at their local restaurants. Our cafe had a website but no options to actually order. As this situatie developped I made this application for the cafe I had been working the year before. 
For the cafe this was a opportunity and for me it was a great project to test what I had learned in the past months.
I guess I was late with learning jQuery. I simply fell in love with plain javaScript. In this project I used jQuery for the first time.

## about this application
The application shows all products available on that moment of the day. Lunch untill 1600. All other products all day. Also there is an option to order products in the future for which an whole other time management system was needed. There is a amount limit for every product.
The customer can pick products and push "ORDER"
A list with selected products will show and a name, telephone, email and prefered pickUpTime can be selected.
After confirming, the customer receives an confirmation email showing their selected products, total price and pickupTime. The email has an option to cancel the order within a certain timeframe
At the same moment the emplyees at the cafe receive a notice on the central computer. At that moment they take measures to have the order ready at the preferred time. 
The custommer pays at pickUp at the cafe.

The employees at the cafe can manage orders by pickuptime. Also they have indicators if an order is canceled by the customer.


## safety
This being my first project I tried hard to take safety into account. I did a lot of reading on OWASP to implement as mush safety measures as possible. Among other things, the application uses, csrf_tokens, ssh_keys and data encryption for the customer data that is collected in the database.

There is also the issue with timeFrames. The application takes into account that orders can not be places when there is not enough time to make the order. It also takes into account the time it needs to close the (lunch)Kitchen. As instructed by the cafe. An employee has to walk by the computer at least once every 10 minutes to make sure all orders can be handeled with respect of the earliest pickUpTime.

## choices
Haven't looked back on this project since it was finished in march 2020 I know I would make a lot of different choices the next time.

javascript vs php
A lot of html is generated with javaScript. Now I'm more used to generate it in php and within the server. Keeping things more behind the scene.

flatpickr/bootstrap
Not being familiar with many libraries I'm happy to have used bootstrap and a datapicker.

