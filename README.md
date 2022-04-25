# Basic Notes

---

- A global query scope effectively changes our `model::all` method to whatever we set it to.
I just added an `AutScope.php` file which implements that behavior.

- You could create the scope within the model itself without an external class. The behavior is the same. I don't recommend it because it makes our model even more fat.

- In most cases, local query scope is decent I guess. However, if you are willing to keep your model less cluttered with scopes, Implement a Traits class.
