import helpers from "./helpers";
import authorize from "./authorize";
export default (app) => {
  app.mixin(authorize);
  app.mixin(helpers);
};