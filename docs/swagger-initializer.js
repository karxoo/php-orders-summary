window.onload = function() {
  window.ui = SwaggerUIBundle({
    url: "http://localhost:8000/openapi.yaml",
    dom_id: '#swagger-ui',
    presets: [SwaggerUIBundle.presets.apis, SwaggerUIStandalonePreset],
    layout: "BaseLayout"
  });
};