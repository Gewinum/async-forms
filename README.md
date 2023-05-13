# AsyncForms
A virion that could change regular FormAPI.

# What's the difference?

This virion supports await-generator, so it makes code more clean and makes us free from "callback hell"

Example:
```php
$form = new SimpleForm(function(Player $player, ?int $answer = null) {
    if (!isset($answer)) {
        $player->sendMessage("Form is closed!");
        return;
    }
    
    if ($answer !== 0) {
        $player->sendMessage("You've tapped close button!");
        return;
    }
    
    $form = new SimpleForm(function(Player $player, ?int $answer = null) {
        if (!isset($answer)) {
            $player->sendMessage("Form is closed");
            return;
        }
        
        if ($answer !== 0) {
            $player->sendMessage("Okay we will not");
            return;
        }
        
        $player->sendMessage("Yay!");
    });
    
    $form->setTitle("Great!");
    $form->setContent("We will register you now.");
    $form->addButton("Ok!");
    $form->addButton("No");
    
    $player->sendForm($form);
});

$form->setTitle("Welcome!");
$form->setContent("Welcome to the server! How can we help you?");

$form->addButton("I want to register!");
$form->addButton("Close");

$player->sendForm($form);
```

Quite messed up, isn't it? This virion makes code much cleaner:

```php
$form = new SimpleForm(
    title: "Welcome!",
    content: "Welcome to the server! How can we help you?",
    buttons: [
        "register" => new Button("I want to register!"),
        "close" => new Button("Close")
    ]
);

$player->sendForm($form);
yield from $form->awaitForResponse();
$response = $form->getResponse();

if ($response->isClosed()) {
    $player->sendMessage("Form was closed");
    return;
}

if ($response->getSelectedButton() === "close") {
    $player->sendMessage("Okay we will not");
    return;
}

$form = new SimpleForm(
    title: "Great!",
    content: "We will register you now.",
    buttons: [
        "ok" => new Button("Ok!"),
        "no" => new Button("No")
    ]
);

$player->sendForm($form);
yield from $form->awaitForResponse();
$response = $form->getResponse();

if ($response->isClosed()) {
    $player->sendMessage("Form is closed");
    return;
}

if ($response->getSelectedButton() === "no") {
    $player->sendMessage("Okay we will not");
    return;
}

$player->sendMessage("Yay!");
```

# Documentation

Documentation will be created later!